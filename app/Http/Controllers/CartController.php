<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionVariant;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',

            'options' => 'nullable|array',
            'options.*' => 'nullable',

            'variants' => 'nullable|array',
            'variants.*' => 'nullable|exists:product_option_variants,variant_id',

            'custom_colors' => 'nullable|array',
            'custom_colors.*' => 'nullable|string|max:255',

        ]);

        $product = Product::with([
            'mainImage',
            'priceRules.options',
            'priceRules.tiers',
            'optionPriceRules.options',
            'optionPriceRules.tiers',
        ])
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $quantity = (int) $request->quantity;

        $selectedOptions = [];
        $selectedOptionIds = [];
        $optionTotal = 0;

        $normalizedOptions = [];

        foreach ($request->input('options', []) as $groupId => $optionValue) {
            if (is_array($optionValue)) {
                foreach ($optionValue as $optionId) {
                    if (! $optionId) {
                        continue;
                    }

                    $normalizedOptions[] = [
                        'group_id' => (int) $groupId,
                        'option_id' => (int) $optionId,
                    ];
                }

                continue;
            }

            if (! $optionValue) {
                continue;
            }

            $normalizedOptions[] = [
                'group_id' => (int) $groupId,
                'option_id' => (int) $optionValue,
            ];
        }

        foreach ($normalizedOptions as $selected) {
            $groupId = $selected['group_id'];
            $optionId = $selected['option_id'];
            if (! $optionId) {
                continue;
            }

            $selectedOptionIds[] = (int) $optionId;

            $option = ProductOption::with(['group', 'priceRates'])
                ->where('option_id', $optionId)
                ->first();

            if (! $option) {
                continue;
            }

            $assignment = \DB::table('product_option_assignments')
                ->where('product_id', $product->product_id)
                ->where('option_id', $option->option_id)
                ->first();

            $variant = null;

            if ($request->filled("variants.$optionId")) {
                $variant = ProductOptionVariant::where('variant_id', $request->input("variants.$optionId"))
                    ->where('option_id', $optionId)
                    ->first();
            }

            $optionPrice = $this->optionPrice($option, $quantity);
            $variantPrice = $this->variantPrice($variant);
            $previousOrderNos = $request->input('previous_order_no', []);

            $selectedOptions[] = [
                'group_id' => $option->option_group_id,
                'group_name' => $option->group->group_name ?? '',
                'option_id' => $option->option_id,
                'option_name' => $option->option_name,

                'is_color_option' => ($option->group->display_type ?? '') === 'color',
                'is_pantone_dic' => preg_match('/PANTONE|DIC/i', $option->option_name) ? 1 : 0,

                'price' => $optionPrice,
                'price_type' => $option->price_type,

                'free_from_qty' => $option->free_from_qty,

                'qty_rule_type' => $assignment->qty_rule_type ?? null,
                'min_qty' => $assignment->min_qty ?? null,
                'max_qty' => $assignment->max_qty ?? null,
                'exact_qty' => $assignment->exact_qty ?? null,

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
        //     'quantity' => $quantity,
        //     'selectedOptionIds' => $selectedOptionIds,
        //     'matchedRule' => $matchedRule ? [
        //         'rule_id' => $matchedRule->rule_id,
        //         'rule_name' => $matchedRule->rule_name,
        //         'option_ids' => $matchedRule->options->pluck('option_id')->values(),
        //         'tiers' => $matchedRule->tiers->map(function ($tier) {
        //             return [
        //                 'min_qty' => $tier->min_qty,
        //                 'max_qty' => $tier->max_qty,
        //                 'unit_price' => $tier->unit_price,
        //                 'unit_price_with_tax' => $tier->unit_price_with_tax ?? null,
        //             ];
        //         })->values(),
        //     ] : null,
        //     'unitPrice' => $unitPrice,
        // ]);

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

        $selectedOptions = $this->applyOptionPriceRulesToSelectedOptions(
            $selectedOptions,
            $product,
            $selectedOptionIds,
            $quantity
        );

        $freeColorUsedByGroup = [];

        foreach ($selectedOptions as $selectedOption) {
            $isRuleOption = in_array((int) $selectedOption['option_id'], $ruleOptionIds);

            if ($isRuleOption) {
                continue;
            }

            $price = (float) ($selectedOption['price'] ?? 0);
            $variantPrice = (float) ($selectedOption['variant_price'] ?? 0);
            $priceType = $selectedOption['price_type'] ?? 'per_order';

            $freeFromQty = ! empty($selectedOption['free_from_qty'])
                ? (int) $selectedOption['free_from_qty']
                : null;

            if ($freeFromQty && $quantity >= $freeFromQty) {
                $price = 0;
            }

            $isColorOption = ! empty($selectedOption['is_color_option']);
            $isPantoneDic = ! empty($selectedOption['is_pantone_dic']);
            $colorGroupId = (int) ($selectedOption['group_id'] ?? 0);

            if ($isColorOption && ! $isPantoneDic && empty($freeColorUsedByGroup[$colorGroupId])) {
                $price = 0;
                $freeColorUsedByGroup[$colorGroupId] = true;
            }

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
            'previous_order_no' => $previousOrderNos,
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
                'optionPriceRules.options',
                'optionPriceRules.tiers',
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

            $itemOptions = collect($item['options'] ?? [])->map(function ($selectedOption) use ($quantity) {
                $optionId = (int) ($selectedOption['option_id'] ?? 0);

                $option = ProductOption::with('priceRates')
                    ->where('option_id', $optionId)
                    ->first();

                if ($option) {
                    $selectedOption['price'] = $this->optionPrice($option, $quantity);
                }

                if (! empty($selectedOption['variant_id'])) {
                    $variant = ProductOptionVariant::where('variant_id', $selectedOption['variant_id'])->first();

                    if ($variant) {
                        $selectedOption['variant_price'] = $this->variantPrice($variant);
                    }
                }

                return $selectedOption;
            })->toArray();

            $itemOptions = $this->applyOptionPriceRulesToSelectedOptions(
                $itemOptions,
                $product,
                $selectedOptionIds,
                $quantity
            );

            $cart[$key]['options'] = $itemOptions;

            $optionTotal = 0;

            $freeColorUsedByGroup = [];

            foreach ($itemOptions as $selectedOption) {
                $optionId = (int) ($selectedOption['option_id'] ?? 0);

                if (in_array($optionId, $ruleOptionIds)) {
                    continue;
                }

                $option = ProductOption::with('priceRates')
                    ->where('option_id', $optionId)
                    ->first();

                $price = $option ? $this->optionPrice($option, $quantity) : (float) ($selectedOption['price'] ?? 0);

                $variantPrice = 0;

                if (! empty($selectedOption['variant_id'])) {
                    $variant = ProductOptionVariant::where('variant_id', $selectedOption['variant_id'])->first();
                    $variantPrice = $this->variantPrice($variant);
                } else {
                    $variantPrice = (float) ($selectedOption['variant_price'] ?? 0);
                }

                $freeFromQty = ! empty($selectedOption['free_from_qty'])
    ? (int) $selectedOption['free_from_qty']
    : null;

                if ($freeFromQty && $quantity >= $freeFromQty) {
                    $price = 0;
                }

                $isColorOption = ! empty($selectedOption['is_color_option']);
                $isPantoneDic = ! empty($selectedOption['is_pantone_dic']);
                $colorGroupId = (int) ($selectedOption['group_id'] ?? 0);

                if ($isColorOption && ! $isPantoneDic && empty($freeColorUsedByGroup[$colorGroupId])) {
                    $price = 0;
                    $freeColorUsedByGroup[$colorGroupId] = true;
                }

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
        $priceTaxMode = $this->priceTaxMode();
        $useTaxIncludedPrice = $this->useTaxIncludedPrice();

        return view('cart.index', compact('cart', 'priceTaxMode', 'useTaxIncludedPrice'));
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

        $quantityError = $this->validateCartItemQuantityRules($cartItem, $quantity);

        if ($quantityError) {
            return redirect()
                ->route('cart.index')
                ->with('error', $quantityError);
        }

        $product = Product::with([
            'mainImage',
            'priceRules.options',
            'priceRules.tiers',
            'optionPriceRules.options',
            'optionPriceRules.tiers',
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

        $cartItemOptions = collect($cartItem['options'] ?? [])->map(function ($selectedOption) use ($quantity) {
            $optionId = (int) ($selectedOption['option_id'] ?? 0);

            $option = ProductOption::with('priceRates')
                ->where('option_id', $optionId)
                ->first();

            if ($option) {
                $selectedOption['price'] = $this->optionPrice($option, $quantity);
            }

            if (! empty($selectedOption['variant_id'])) {
                $variant = ProductOptionVariant::where('variant_id', $selectedOption['variant_id'])->first();

                if ($variant) {
                    $selectedOption['variant_price'] = $this->variantPrice($variant);
                }
            }

            return $selectedOption;
        })->toArray();

        $cartItemOptions = $this->applyOptionPriceRulesToSelectedOptions(
            $cartItemOptions,
            $product,
            $selectedOptionIds,
            $quantity
        );

        /*
        |--------------------------------------------------------------------------
        | Recalculate option total
        |--------------------------------------------------------------------------
        | Rule options are already included in unit price, so skip them.
        | Other options with additional_price will be added.
        */
        $optionTotal = 0;

        $freeColorUsedByGroup = [];

        foreach ($cartItemOptions as $selectedOption) {
            $optionId = (int) ($selectedOption['option_id'] ?? 0);

            if (in_array($optionId, $ruleOptionIds)) {
                continue;
            }

            $option = ProductOption::with('priceRates')
                ->where('option_id', $optionId)
                ->first();

            $price = $option ? $this->optionPrice($option, $quantity) : (float) ($selectedOption['price'] ?? 0);

            $variantPrice = 0;

            if (! empty($selectedOption['variant_id'])) {
                $variant = ProductOptionVariant::where('variant_id', $selectedOption['variant_id'])->first();
                $variantPrice = $this->variantPrice($variant);
            } else {
                $variantPrice = (float) ($selectedOption['variant_price'] ?? 0);
            }

            $freeFromQty = ! empty($selectedOption['free_from_qty'])
    ? (int) $selectedOption['free_from_qty']
    : null;

            if ($freeFromQty && $quantity >= $freeFromQty) {
                $price = 0;
            }

            $isColorOption = ! empty($selectedOption['is_color_option']);
            $isPantoneDic = ! empty($selectedOption['is_pantone_dic']);
            $colorGroupId = (int) ($selectedOption['group_id'] ?? 0);

            if ($isColorOption && ! $isPantoneDic && empty($freeColorUsedByGroup[$colorGroupId])) {
                $price = 0;
                $freeColorUsedByGroup[$colorGroupId] = true;
            }

            $priceType = $selectedOption['price_type'] ?? 'per_order';

            if ($priceType === 'per_item') {
                $optionTotal += ($price + $variantPrice) * $quantity;
            } else {
                $optionTotal += $price + $variantPrice;
            }
            // $cart[$key]['options'] = collect($item['options'] ?? [])->map(function ($selectedOption) {
            //     $optionId = (int) ($selectedOption['option_id'] ?? 0);
            //     $option = ProductOption::where('option_id', $optionId)->first();

            //     if ($option) {
            //         $selectedOption['price'] = $this->optionPrice($option);
            //     }

            //     if (! empty($selectedOption['variant_id'])) {
            //         $variant = ProductOptionVariant::where('variant_id', $selectedOption['variant_id'])->first();

            //         if ($variant) {
            //             $selectedOption['variant_price'] = $this->variantPrice($variant);
            //         }
            //     }

            //     return $selectedOption;
            // })->toArray();
        }

        $productTotal = $unitPrice * $quantity;
        $itemTotal = $productTotal + $optionTotal;

        $cart[$cartItemId]['quantity'] = $quantity;
        $cart[$cartItemId]['options'] = $cartItemOptions;

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

    private function applyOptionPriceRulesToSelectedOptions(array $selectedOptions, Product $product, array $selectedOptionIds, int $quantity): array
    {
        $selectedOptionIds = collect($selectedOptionIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        return collect($selectedOptions)
            ->map(function ($selectedOption) use ($product, $selectedOptionIds, $quantity) {
                $optionId = (int) ($selectedOption['option_id'] ?? 0);

                if (! $optionId) {
                    return $selectedOption;
                }

                $matchedRule = $this->findMatchedOptionPriceRule($product, $optionId, $selectedOptionIds);

                if ($matchedRule) {
                    $selectedOption['price'] = $this->findOptionRuleTierPrice($matchedRule, $quantity);
                }

                return $selectedOption;
            })
            ->toArray();
    }

    private function findMatchedOptionPriceRule(Product $product, int $targetOptionId, array $selectedOptionIds)
    {
        $selectedOptionIds = collect($selectedOptionIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $rules = $product->relationLoaded('optionPriceRules')
            ? $product->optionPriceRules
            : $product->optionPriceRules()->with(['options', 'tiers'])->get();

        $matchedRules = $rules->filter(function ($rule) use ($targetOptionId, $selectedOptionIds) {
            if ((int) $rule->target_option_id !== $targetOptionId) {
                return false;
            }

            $conditionOptionIds = $rule->options
                ->pluck('option_id')
                ->map(fn ($id) => (int) $id)
                ->filter()
                ->unique()
                ->values()
                ->toArray();

            if (empty($conditionOptionIds)) {
                return false;
            }

            return empty(array_diff($conditionOptionIds, $selectedOptionIds));
        });

        return $matchedRules
            ->sortByDesc(function ($rule) {
                return $rule->options->count();
            })
            ->first();
    }

    private function findOptionRuleTierPrice($rule, int $quantity): float
    {
        $tiers = $rule->tiers;

        $matchedTier = $tiers
            ->filter(function ($tier) use ($quantity) {
                return $quantity >= $tier->min_qty
                    && (
                        is_null($tier->max_qty)
                        || $quantity <= $tier->max_qty
                    );
            })
            ->sortByDesc('min_qty')
            ->first();

        if (! $matchedTier) {
            $matchedTier = $tiers
                ->sortByDesc('min_qty')
                ->first();
        }

        if (! $matchedTier) {
            return 0;
        }

        if ($this->useTaxIncludedPrice()) {
            return (float) ($matchedTier->additional_price_with_tax ?? $matchedTier->additional_price ?? 0);
        }

        return (float) ($matchedTier->additional_price ?? 0);
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

        if (! $matchedTier) {
            return 0;
        }

        if ($this->useTaxIncludedPrice()) {
            return (float) ($matchedTier->unit_price_with_tax ?? $matchedTier->unit_price ?? 0);
        }

        return (float) ($matchedTier->unit_price ?? 0);
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

    private function validateCartItemQuantityRules(array $cartItem, int $quantity): ?string
    {
        foreach (($cartItem['options'] ?? []) as $option) {
            $ruleType = $option['qty_rule_type'] ?? null;

            if (! $ruleType) {
                continue;
            }

            $optionName = $option['option_name'] ?? 'Selected option';

            $minQty = ! empty($option['min_qty']) ? (int) $option['min_qty'] : null;
            $maxQty = ! empty($option['max_qty']) ? (int) $option['max_qty'] : null;
            $exactQty = ! empty($option['exact_qty']) ? (int) $option['exact_qty'] : null;

            if ($ruleType === 'min' && $minQty && $quantity < $minQty) {
                return "{$optionName}: minimum quantity is {$minQty} pcs.";
            }

            if ($ruleType === 'max' && $maxQty && $quantity > $maxQty) {
                return "{$optionName}: maximum quantity is {$maxQty} pcs.";
            }

            if ($ruleType === 'exact' && $exactQty && $quantity !== $exactQty) {
                return "{$optionName}: quantity must be exactly {$exactQty} pcs.";
            }

            if ($ruleType === 'range') {
                if ($minQty && $quantity < $minQty) {
                    return "{$optionName}: minimum quantity is {$minQty} pcs.";
                }

                if ($maxQty && $quantity > $maxQty) {
                    return "{$optionName}: maximum quantity is {$maxQty} pcs.";
                }
            }
        }

        return null;
    }

    private function priceTaxMode(): string
    {
        return Cache::remember('system_setting_price_tax_mode', 3600, function () {
            return SystemSetting::getValue('price_tax_mode', 'exclude_tax');
        });
    }

    private function useTaxIncludedPrice(): bool
    {
        return $this->priceTaxMode() === 'include_tax';
    }

    private function optionPrice(ProductOption $option, ?int $quantity = null): float
    {
        $basePrice = $this->useTaxIncludedPrice()
            ? (float) ($option->additional_price_with_tax ?? $option->additional_price ?? 0)
            : (float) ($option->additional_price ?? 0);

        if (! $quantity) {
            return $basePrice;
        }

        if (! $option->relationLoaded('priceRates')) {
            $option->load('priceRates');
        }

        if (! $option->priceRates || ! $option->priceRates->count()) {
            return $basePrice;
        }

        $matchedRate = $option->priceRates
            ->where('min_qty', '<=', $quantity)
            ->sortByDesc('min_qty')
            ->first();

        if (! $matchedRate) {
            return $basePrice;
        }

        return $this->useTaxIncludedPrice()
            ? (float) ($matchedRate->additional_price_with_tax ?? $matchedRate->additional_price ?? 0)
            : (float) ($matchedRate->additional_price ?? 0);
    }

    private function variantPrice($variant): float
    {
        if (! $variant) {
            return 0;
        }

        if ($this->useTaxIncludedPrice()) {
            return (float) ($variant->additional_price_with_tax ?? $variant->additional_price ?? 0);
        }

        return (float) ($variant->additional_price ?? 0);
    }
}
