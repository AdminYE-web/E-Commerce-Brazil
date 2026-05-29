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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $language = session('admin_product_language', 'pt');

        $rules = ProductPriceRule::with(['product'])
            ->whereHas('product', function ($productQuery) use ($language) {
                $productQuery->where('language', $language);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('rule_name', 'like', '%' . $search . '%')
                        ->orWhereHas('product', function ($productQuery) use ($search) {
                            $productQuery->where('product_name', 'like', '%' . $search . '%')
                                ->orWhere('product_code', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderBy('rule_id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.product_price_rules.index', compact('rules', 'search', 'language'));
    }

    public function create()
    {
        $language = session('admin_product_language', 'pt');

        $products = Product::where('language', $language)
            ->orderBy('product_name')
            ->get();

        $options = ProductOption::with('group')
            ->where('language', $language)
            ->where('is_active', 1)
            ->whereHas('group', function ($query) use ($language) {
                $query->where('language', $language)
                    ->where('option_group_main', 1);
            })
            ->orderBy('option_group_id')
            ->orderBy('option_name')
            ->get();

        return view('admin.product_price_rules.create', compact('products', 'options', 'language'));
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
            'tiers.*.unit_price_with_tax' => 'nullable|numeric|min:0',

            'is_active' => 'nullable|boolean',
            'display_tier_index' => 'nullable|integer|min:0',
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

        $displayTierIndex = (int) $request->input('display_tier_index', 0);

        $this->resetDisplayTiersByProduct((int) $request->product_id);

        $tiers = collect($request->tiers)
            ->map(function ($tier, $index) {
                $tier['form_index'] = (int) $index;

                return $tier;
            })
            ->filter(function ($tier) {
                return ! empty($tier['min_qty']) && isset($tier['unit_price']);
            })
            ->sortBy(function ($tier) {
                return (int) $tier['min_qty'];
            })
            ->values();

        foreach ($tiers as $index => $tier) {
            $nextTier = $tiers->get($index + 1);

            $maxQty = null;

            if ($nextTier) {
                $maxQty = ((int) $nextTier['min_qty']) - 1;
            }

            ProductPriceRuleTier::create([
                'rule_id' => $rule->rule_id,
                'min_qty' => (int) $tier['min_qty'],
                'max_qty' => $maxQty,
                'unit_price' => $tier['unit_price'],
                'is_display' => (int) $tier['form_index'] === $displayTierIndex ? 1 : 0,
                'is_active' => 1,
                'unit_price_with_tax' => $tier['unit_price_with_tax'] ?? null,
            ]);
        }

        return redirect()
            ->route('admin.product-price-rules.index')
            ->with('success', 'Product price rule created successfully.');
    }

    public function edit(ProductPriceRule $productPriceRule)
    {
        $productPriceRule->load(['product', 'options', 'tiers']);

        $language = $productPriceRule->product->language
            ?? session('admin_product_language', 'pt');

        $products = Product::where('language', $language)
            ->orderBy('product_name')
            ->get();

        $options = ProductOption::with('group')
            ->where('language', $language)
            ->where('is_active', 1)
            ->whereHas('group', function ($query) use ($language) {
                $query->where('language', $language)
                    ->where('option_group_main', 1);
            })
            ->orderBy('option_group_id')
            ->orderBy('option_name')
            ->get();

        return view('admin.product_price_rules.edit', [
            'rule' => $productPriceRule,
            'products' => $products,
            'options' => $options,
            'language' => $language,
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
            'tiers.*.unit_price_with_tax' => 'nullable|numeric|min:0',

            'is_active' => 'nullable|boolean',
            'display_tier_index' => 'nullable|integer|min:0',
        ]);

        $productPriceRule->update([
            'product_id' => $request->product_id,
            'rule_name' => $request->rule_name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        ProductPriceRuleOption::where('rule_id', $productPriceRule->rule_id)->delete();
        ProductPriceRuleTier::where('rule_id', $productPriceRule->rule_id)->delete();

        $this->resetDisplayTiersByProduct((int) $request->product_id);

        foreach ($request->option_ids as $optionId) {
            ProductPriceRuleOption::create([
                'rule_id' => $productPriceRule->rule_id,
                'option_id' => $optionId,
            ]);
        }

        $displayTierIndex = (int) $request->input('display_tier_index', 0);

        $tiers = collect($request->tiers)
            ->map(function ($tier, $index) {
                $tier['form_index'] = (int) $index;

                return $tier;
            })
            ->filter(function ($tier) {
                return ! empty($tier['min_qty']) && isset($tier['unit_price']);
            })
            ->sortBy(function ($tier) {
                return (int) $tier['min_qty'];
            })
            ->values();

        foreach ($tiers as $index => $tier) {
            $nextTier = $tiers->get($index + 1);

            $maxQty = null;

            if ($nextTier) {
                $maxQty = ((int) $nextTier['min_qty']) - 1;
            }

            ProductPriceRuleTier::create([
                'rule_id' => $productPriceRule->rule_id,
                'min_qty' => (int) $tier['min_qty'],
                'max_qty' => $maxQty,
                'unit_price' => $tier['unit_price'],
                'is_display' => (int) $tier['form_index'] === $displayTierIndex ? 1 : 0,
                'is_active' => 1,
                'unit_price_with_tax' => $tier['unit_price_with_tax'] ?? null,
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

    public function show($id)
    {
        $rule = ProductPriceRule::with([
            'product',
            'options.group',
            'tiers',
        ])
            ->where('rule_id', $id)
            ->firstOrFail();

        return view('admin.product_price_rules.show', compact('rule'));
    }

    public function getProductOptions(Product $product)
    {
        $language = $product->language ?? session('admin_product_language', 'pt');

        $options = $product->options()
            ->with('group')
            ->wherePivot('is_active', 1)
            ->where('product_options.is_active', 1)
            ->where('product_options.language', $language)
            ->whereHas('group', function ($query) use ($language) {
                $query->where('language', $language)
                    ->where('option_group_main', 1);
            })
            ->orderBy('product_option_assignments.sort_order')
            ->orderBy('product_options.option_id')
            ->get();

        $groupedOptions = $options
            ->groupBy('option_group_id')
            ->map(function ($groupOptions) {
                $group = $groupOptions->first()->group;

                return [
                    'group_id' => $group->option_group_id ?? null,
                    'group_name' => $group->group_name ?? '-',
                    'options' => $groupOptions->map(function ($option) {
                        return [
                            'option_id' => $option->option_id,
                            'option_name' => $option->option_name,
                        ];
                    })->values(),
                ];
            })
            ->values();

        return response()->json([
            'groups' => $groupedOptions,
        ]);
    }

    private function resetDisplayTiersByProduct(int $productId): void
    {
        $ruleIds = ProductPriceRule::where('product_id', $productId)
            ->pluck('rule_id');

        if ($ruleIds->isEmpty()) {
            return;
        }

        ProductPriceRuleTier::whereIn('rule_id', $ruleIds)
            ->update([
                'is_display' => 0,
            ]);
    }
}
