<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductPriceRule;
use App\Models\ProductPriceRuleOption;
use App\Models\ProductPriceRuleTier;
use Illuminate\Http\Request;

class ProductPriceRuleController extends Controller
{
    public function index()
    {
        $rules = ProductPriceRule::with(['product', 'options.group', 'tiers'])
            ->orderBy('rule_id', 'desc')
            ->paginate(20);

        return view('admin.product_price_rules.index', compact('rules'));
    }

    public function create()
    {
        $products = Product::orderBy('product_name')->get();

       $options = ProductOption::with('group')
    ->where('is_active', 1)
    ->whereHas('group', function ($query) {
        $query->where('option_group_main', 1);
    })
    ->orderBy('option_group_id')
    ->orderBy('option_name')
    ->get();

        return view('admin.product_price_rules.create', compact('products', 'options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'rule_name' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',

            'option_ids' => 'required|array|min:1',
            'option_ids.*' => 'exists:product_options,option_id',

            'tiers' => 'required|array|min:1',
            'tiers.*.min_qty' => 'required|integer|min:1',
            'tiers.*.max_qty' => 'nullable|integer|min:1',
            'tiers.*.unit_price' => 'required|numeric|min:0',

            'is_active' => 'nullable|boolean',
        ]);

        $rule = ProductPriceRule::create([
            'product_id' => $request->product_id,
            'rule_name' => $request->rule_name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        foreach ($request->option_ids as $optionId) {
            ProductPriceRuleOption::create([
                'rule_id' => $rule->rule_id,
                'option_id' => $optionId,
            ]);
        }

        foreach ($request->tiers as $tier) {
            ProductPriceRuleTier::create([
                'rule_id' => $rule->rule_id,
                'min_qty' => $tier['min_qty'],
                'max_qty' => $tier['max_qty'] ?? null,
                'unit_price' => $tier['unit_price'],
                'is_active' => 1,
            ]);
        }

        return redirect()
            ->route('admin.product-price-rules.index')
            ->with('success', 'Product price rule created successfully.');
    }

    public function edit(ProductPriceRule $productPriceRule)
    {
        $productPriceRule->load(['options', 'tiers']);

        $products = Product::orderBy('product_name')->get();

       $options = ProductOption::with('group')
    ->where('is_active', 1)
    ->whereHas('group', function ($query) {
        $query->where('option_group_main', 1);
    })
    ->orderBy('option_group_id')
    ->orderBy('option_name')
    ->get();

        return view('admin.product_price_rules.edit', [
            'rule' => $productPriceRule,
            'products' => $products,
            'options' => $options,
        ]);
    }

    public function update(Request $request, ProductPriceRule $productPriceRule)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'rule_name' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',

            'option_ids' => 'required|array|min:1',
            'option_ids.*' => 'exists:product_options,option_id',

            'tiers' => 'required|array|min:1',
            'tiers.*.min_qty' => 'required|integer|min:1',
            'tiers.*.max_qty' => 'nullable|integer|min:1',
            'tiers.*.unit_price' => 'required|numeric|min:0',

            'is_active' => 'nullable|boolean',
        ]);

        $productPriceRule->update([
            'product_id' => $request->product_id,
            'rule_name' => $request->rule_name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        ProductPriceRuleOption::where('rule_id', $productPriceRule->rule_id)->delete();
        ProductPriceRuleTier::where('rule_id', $productPriceRule->rule_id)->delete();

        foreach ($request->option_ids as $optionId) {
            ProductPriceRuleOption::create([
                'rule_id' => $productPriceRule->rule_id,
                'option_id' => $optionId,
            ]);
        }

        foreach ($request->tiers as $tier) {
            ProductPriceRuleTier::create([
                'rule_id' => $productPriceRule->rule_id,
                'min_qty' => $tier['min_qty'],
                'max_qty' => $tier['max_qty'] ?? null,
                'unit_price' => $tier['unit_price'],
                'is_active' => 1,
            ]);
        }

        return redirect()
            ->route('admin.product-price-rules.index')
            ->with('success', 'Product price rule updated successfully.');
    }

    public function destroy(ProductPriceRule $productPriceRule)
    {
        $productPriceRule->delete();

        return redirect()
            ->route('admin.product-price-rules.index')
            ->with('success', 'Product price rule deleted successfully.');
    }
}