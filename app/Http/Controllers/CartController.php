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
            'quantity' => 'required|integer|min:20',

            'options' => 'nullable|array',
            'options.*' => 'nullable|exists:product_options,option_id',

            'variants' => 'nullable|array',
            'variants.*' => 'nullable|exists:product_option_variants,variant_id',

            'custom_colors' => 'nullable|array',
            'custom_colors.*' => 'nullable|string|max:255',
        ]);

        $product = Product::with(['mainImage', 'priceTiers'])
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $quantity = (int) $request->quantity;

        /*
        |--------------------------------------------------------------------------
        | Find unit price from product_price_tiers
        |--------------------------------------------------------------------------
        | 1. First, find tier that matches quantity.
        | 2. If no tier matches, use the highest min_qty tier.
        |
        | Example:
        | 1 - 5  = 100
        | 6 - 10 = 80
        | qty 11 will use 80
        */
        $priceTier = $product->priceTiers
            ->first(function ($tier) use ($quantity) {
                return $quantity >= $tier->min_qty
                    && (
                        is_null($tier->max_qty)
                        || $quantity <= $tier->max_qty
                    );
            });

        if (!$priceTier) {
            $priceTier = $product->priceTiers
                ->sortByDesc('min_qty')
                ->first();
        }

        $unitPrice = $priceTier ? (float) $priceTier->unit_price : 0;

        $selectedOptions = [];
        $optionTotal = 0;

        foreach ($request->input('options', []) as $groupId => $optionId) {
            if (!$optionId) {
                continue;
            }

            $option = ProductOption::with('group')
                ->where('option_id', $optionId)
                ->first();

            if (!$option) {
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

            /*
             * ถ้า price_type = per_item ให้คูณจำนวน
             * ถ้า price_type = per_order ให้คิดครั้งเดียว
             */
            if ($option->price_type === 'per_item') {
                $optionTotal += ($optionPrice + $variantPrice) * $quantity;
            } else {
                $optionTotal += ($optionPrice + $variantPrice);
            }

            $selectedOptions[] = [
                'group_id' => $option->option_group_id,
                'group_name' => $option->group->group_name ?? '',
                'option_id' => $option->option_id,
                'option_name' => $option->option_name,

                'price' => $optionPrice,
                'price_type' => $option->price_type,

                'variant_id' => $variant->variant_id ?? null,
                'variant_name' => $variant->variant_name ?? null,
                'variant_price' => $variantPrice,
                'variant_image' => $variant->image_path ?? null,
            ];
        }

        $customColors = [];

        foreach ($request->input('custom_colors', []) as $groupId => $colorText) {
            if (!$colorText) {
                continue;
            }

            $customColors[] = [
                'group_id' => $groupId,
                'group_name' => 'Special Cord Colors',
                'value' => $colorText,
            ];
        }

        $productTotal = $unitPrice * $quantity;
        $grandTotal = $productTotal + $optionTotal;

        $cart = session()->get('cart', []);

        $cartItemId = uniqid('cart_', true);

        $cart[$cartItemId] = [
            'cart_item_id' => $cartItemId,

            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'product_image' => $product->mainImage->image_path ?? null,

            'quantity' => $quantity,

            // ราคาจาก product_price_tiers
            'unit_price' => $unitPrice,
            'product_total' => $productTotal,

            // ราคา option
            'option_total' => $optionTotal,

            // รวมทั้งหมด
            'grand_total' => $grandTotal,

            'options' => $selectedOptions,
            'custom_colors' => $customColors,
        ];

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product added to cart.');
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }
}