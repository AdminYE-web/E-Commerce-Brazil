<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',

            'options' => 'nullable|array',
            'options.*' => 'nullable|exists:product_options,option_id',

            'variants' => 'nullable|array',
            'variants.*' => 'nullable|exists:product_option_variants,variant_id',

            'custom_colors' => 'nullable|array',
            'custom_colors.*' => 'nullable|string|max:255',
        ]);

        $product = Product::with([
            'mainImage',
            'priceRules.options',
            'priceRules.tiers',
        ])
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $quantity = (int) $request->quantity;

        $selectedOptions = [];
        $selectedOptionIds = [];
        $optionTotal = 0;

        foreach ($request->input('options', []) as $groupId => $optionId) {
            if (! $optionId) {
                continue;
            }

            $selectedOptionIds[] = (int) $optionId;

            $option = ProductOption::with('group')
                ->where('option_id', $optionId)
                ->first();

            if (! $option) {
                continue;
            }

            $variant = null;

            if ($request->filled("variants.$optionId")) {
                $variant = ProductOptionVariant::where('variant_id', $request->input("variants.$optionId"))
                    ->where('option_id', $optionId)
                    ->first();
            }

            $optionPrice = (float) ($option->additional_price ?? 0);
            $variantPrice = (float) ($variant->additional_price ?? 0);

            $selectedOptions[] = [
                'group_id' => $option->option_group_id,
                'group_name' => $option->group->group_name ?? '',
                'option_id' => $option->option_id,
                'option_name' => $option->option_name,

                'price' => $optionPrice,
                'price_type' => $option->price_type,

                'color_code' => $option->color_code ?? null,

                'variant_id' => $variant->variant_id ?? null,
                'variant_name' => $variant->variant_name ?? null,
                'variant_price' => $variantPrice,
                'variant_image' => $variant->image_path ?? null,
                'variant_color_code' => $variant->color_code ?? null,
            ];
        }

        $matchedRule = $this->findMatchedPriceRule($product, $selectedOptionIds);
        $unitPrice = $this->findTierPrice($matchedRule, $quantity);

//         dd([
//     'product_id' => $product->product_id,
//     'quantity' => $quantity,
//     'selectedOptionIds' => $selectedOptionIds,
//     'matchedRule' => $matchedRule ? [
//         'rule_id' => $matchedRule->rule_id,
//         'rule_name' => $matchedRule->rule_name,
//         'rule_options' => $matchedRule->options->map(function ($option) {
//             return [
//                 'option_id' => $option->option_id,
//                 'group_name' => $option->group->group_name ?? null,
//                 'option_name' => $option->option_name,
//             ];
//         })->values(),
//         'tiers' => $matchedRule->tiers->map(function ($tier) {
//             return [
//                 'min_qty' => $tier->min_qty,
//                 'max_qty' => $tier->max_qty,
//                 'unit_price' => $tier->unit_price,
//             ];
//         })->values(),
//     ] : null,
//     'unitPrice' => $unitPrice,
// ]);

        $ruleOptionIds = $matchedRule
            ? $matchedRule->options->pluck('option_id')->map(fn ($id) => (int) $id)->toArray()
            : [];

        foreach ($selectedOptions as $selectedOption) {
            $isRuleOption = in_array((int) $selectedOption['option_id'], $ruleOptionIds);

            if ($isRuleOption) {
                continue;
            }

            $price = (float) ($selectedOption['price'] ?? 0);
            $variantPrice = (float) ($selectedOption['variant_price'] ?? 0);
            $priceType = $selectedOption['price_type'] ?? 'per_order';

            if ($priceType === 'per_item') {
                $optionTotal += ($price + $variantPrice) * $quantity;
            } else {
                $optionTotal += $price + $variantPrice;
            }
        }

        $customColors = [];

        foreach ($request->input('custom_colors', []) as $groupId => $colorText) {
            if (! $colorText) {
                continue;
            }

            $customColors[] = [
                'group_id' => $groupId,
                'group_name' => 'Special Cord Colors',
                'value' => $colorText,
            ];
        }

        $productTotal = $unitPrice * $quantity;
        $itemTotal = $productTotal + $optionTotal;

        $cart = session()->get('cart', []);

        $cartItemId = $request->input('cart_item_id');

        if ($cartItemId && isset($cart[$cartItemId])) {
            // update item เดิม
            $finalCartItemId = $cartItemId;
        } else {
            // add item ใหม่
            $finalCartItemId = uniqid('cart_', true);
        }

        $cart[$finalCartItemId] = [
            'cart_item_id' => $finalCartItemId,

            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'product_image' => $product->mainImage->image_path ?? null,

            'quantity' => $quantity,

            'price_rule_id' => $matchedRule->rule_id ?? null,
            'price_rule_name' => $matchedRule->rule_name ?? null,

            'unit_price' => $unitPrice,
            'product_total' => $productTotal,
            'option_total' => $optionTotal,
            'item_total' => $itemTotal,
            'grand_total' => $itemTotal,

            'options' => $selectedOptions,
            'custom_colors' => $customColors,
        ];

        session()->put('cart', $cart);

        session()->forget([
            'editing_cart_item_id',
            'editing_cart_item',
        ]);

        return redirect()
            ->route('cart.index')
            ->with('success', $cartItemId ? 'Cart item updated.' : 'Product added to cart.');
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $key => $item) {
            $quantity = (int) ($item['quantity'] ?? 1);

            $product = Product::with([
                'mainImage',
                'priceRules.options',
                'priceRules.tiers',
            ])
                ->where('product_id', $item['product_id'])
                ->first();

            if (! $product) {
                continue;
            }

            $selectedOptionIds = collect($item['options'] ?? [])
                ->pluck('option_id')
                ->map(fn ($id) => (int) $id)
                ->toArray();

            $matchedRule = $this->findMatchedPriceRule($product, $selectedOptionIds);
            $unitPrice = $this->findTierPrice($matchedRule, $quantity);

            $ruleOptionIds = $matchedRule
                ? $matchedRule->options->pluck('option_id')->map(fn ($id) => (int) $id)->toArray()
                : [];

            $optionTotal = 0;

            foreach (($item['options'] ?? []) as $selectedOption) {
                $optionId = (int) ($selectedOption['option_id'] ?? 0);

                if (in_array($optionId, $ruleOptionIds)) {
                    continue;
                }

                $price = (float) ($selectedOption['price'] ?? 0);
                $variantPrice = (float) ($selectedOption['variant_price'] ?? 0);
                $priceType = $selectedOption['price_type'] ?? 'per_order';

                if ($priceType === 'per_item') {
                    $optionTotal += ($price + $variantPrice) * $quantity;
                } else {
                    $optionTotal += $price + $variantPrice;
                }
            }

            $productTotal = $unitPrice * $quantity;
            $itemTotal = $productTotal + $optionTotal;

            $cart[$key]['price_rule_id'] = $matchedRule->rule_id ?? null;
            $cart[$key]['price_rule_name'] = $matchedRule->rule_name ?? null;

            $cart[$key]['unit_price'] = $unitPrice;
            $cart[$key]['product_total'] = $productTotal;
            $cart[$key]['option_total'] = $optionTotal;
            $cart[$key]['item_total'] = $itemTotal;
            $cart[$key]['grand_total'] = $itemTotal;
        }

        session()->put('cart', $cart);

        return view('cart.index', compact('cart'));
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $cartItemId = $request->cart_item_id;

        if (! isset($cart[$cartItemId])) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Cart item not found.');
        }

        $quantity = (int) $request->quantity;
        $cartItem = $cart[$cartItemId];

        $product = Product::with([
            'mainImage',
            'priceRules.options',
            'priceRules.tiers',
        ])
            ->where('product_id', $cartItem['product_id'])
            ->first();

        if (! $product) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Product not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Rebuild selected option ids from cart session
        |--------------------------------------------------------------------------
        */
        $selectedOptionIds = collect($cartItem['options'] ?? [])
            ->pluck('option_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Find matched price rule again
        |--------------------------------------------------------------------------
        */
        $matchedRule = $this->findMatchedPriceRule($product, $selectedOptionIds);

        /*
        |--------------------------------------------------------------------------
        | Find unit price again by new quantity
        |--------------------------------------------------------------------------
        */
        $unitPrice = $this->findTierPrice($matchedRule, $quantity);

        $ruleOptionIds = $matchedRule
            ? $matchedRule->options->pluck('option_id')->map(fn ($id) => (int) $id)->toArray()
            : [];

        /*
        |--------------------------------------------------------------------------
        | Recalculate option total
        |--------------------------------------------------------------------------
        | Rule options are already included in unit price, so skip them.
        | Other options with additional_price will be added.
        */
        $optionTotal = 0;

        foreach (($cartItem['options'] ?? []) as $selectedOption) {
            $optionId = (int) ($selectedOption['option_id'] ?? 0);

            if (in_array($optionId, $ruleOptionIds)) {
                continue;
            }

            $price = (float) ($selectedOption['price'] ?? 0);
            $variantPrice = (float) ($selectedOption['variant_price'] ?? 0);
            $priceType = $selectedOption['price_type'] ?? 'per_order';

            if ($priceType === 'per_item') {
                $optionTotal += ($price + $variantPrice) * $quantity;
            } else {
                $optionTotal += $price + $variantPrice;
            }
        }

        $productTotal = $unitPrice * $quantity;
        $itemTotal = $productTotal + $optionTotal;

        $cart[$cartItemId]['quantity'] = $quantity;

        $cart[$cartItemId]['price_rule_id'] = $matchedRule->rule_id ?? null;
        $cart[$cartItemId]['price_rule_name'] = $matchedRule->rule_name ?? null;

        $cart[$cartItemId]['unit_price'] = $unitPrice;
        $cart[$cartItemId]['product_total'] = $productTotal;
        $cart[$cartItemId]['option_total'] = $optionTotal;
        $cart[$cartItemId]['item_total'] = $itemTotal;
        $cart[$cartItemId]['grand_total'] = $itemTotal;

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Quantity updated.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        $cartItemId = $request->cart_item_id;

        if (isset($cart[$cartItemId])) {
            unset($cart[$cartItemId]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removed.');
    }

    private function findMatchedPriceRule(Product $product, array $selectedOptionIds)
{
    $selectedOptionIds = collect($selectedOptionIds)
        ->map(fn ($id) => (int) $id)
        ->filter()
        ->unique()
        ->values()
        ->toArray();

    $rules = $product->priceRules()
        ->with(['options.group', 'tiers'])
        ->get();

    $matchedRules = $rules->filter(function ($rule) use ($selectedOptionIds) {
        $ruleOptionIds = $rule->options
            ->pluck('option_id')
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($ruleOptionIds)) {
            return false;
        }

        // Rule match เมื่อ user เลือก option ที่ rule ต้องการครบ
        // ไม่จำเป็นต้องเลือกเท่ากันเป๊ะ เลือกเกินได้
        return empty(array_diff($ruleOptionIds, $selectedOptionIds));
    });

    return $matchedRules
        ->sortByDesc(function ($rule) {
            // ถ้ามีหลาย rule match ให้ใช้ rule ที่มีเงื่อนไขละเอียดที่สุด
            return $rule->options->count();
        })
        ->first();
}

    private function findTierPrice($rule, int $quantity): float
    {
        if (! $rule) {
            return 0;
        }

        $tiers = $rule->tiers;

        $matchedTier = $tiers->first(function ($tier) use ($quantity) {
            return $quantity >= $tier->min_qty
                && (
                    is_null($tier->max_qty)
                    || $quantity <= $tier->max_qty
                );
        });

        if (! $matchedTier) {
            $matchedTier = $tiers
                ->sortByDesc('min_qty')
                ->first();
        }

        return $matchedTier ? (float) $matchedTier->unit_price : 0;
    }

    public function edit($cartItemId)
    {
        $cart = session()->get('cart', []);

        if (! isset($cart[$cartItemId])) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Cart item not found.');
        }

        $cartItem = $cart[$cartItemId];

        session()->put('editing_cart_item_id', $cartItemId);
        session()->put('editing_cart_item', $cartItem);

        $productId = $cartItem['product_id'];

        $product = Product::where('product_id', $productId)->firstOrFail();

        if ((int) $product->product_type === 1) {
            return redirect()->route('products.hotstrap.show', $product->product_id);
        }

        if ((int) $product->product_type === 2) {
            return redirect()->route('products.hotmobily.show', $product->product_id);
        }

        return redirect()
            ->route('cart.index')
            ->with('error', 'Product type not found.');
    }
}
