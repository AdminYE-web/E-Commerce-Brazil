<?php

namespace App\Http\Controllers;

use App\Models\OptionDependency;
use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductListBanner;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        $categoryIds = $request->input('categories', []);
        $materialIds = $request->input('materials', []);
        $productType = $request->input('product_type', 1);
        $banners = ProductListBanner::where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('banner_id', 'desc')
            ->get();

        $categories = Category::where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('category_id', 'desc')
            ->get();

        $materials = Material::where('is_active', 1)
            ->orderBy('material_name')
            ->get();

        $products = Product::with(['mainImage', 'category', 'material', 'detail'])
            ->where('is_active', 1)
            ->where('product_type', $productType)
            ->when(! empty($categoryIds), function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->when(! empty($materialIds), function ($query) use ($materialIds) {
                $query->whereIn('material_id', $materialIds);
            })
            ->orderBy('product_id', 'desc')
            ->paginate(12)
            ->withQueryString();
        if ($request->ajax() && $request->input('_ajax') == 1) {
    return response()->json([
        'html' => view('products.partials.product_cards', compact('products'))->render(),
        'pagination' => $products->links()->render(),
    ]);
}

        return view('products.index', compact(
            'products',
            'categories',
            'materials',
            'categoryIds',
            'materialIds',
            'productType',
            'banners'
        ));
    }

    public function show(Product $product)
    {
        $product->load(['mainImage', 'images', 'detail', 'category', 'material']);

        return view('products.desc', compact('product'));
    }

   public function showHotstrap(Product $product)
{
    if ((int) $product->product_type !== 1) {
        abort(404);
    }

   $product->load([
    'mainImage',
    'images',
    'galleryImages',
    'detail',
    'category',
    'material',

    // ใช้ของใหม่
    'priceRules.options',
    'priceRules.tiers',

    'assignedOptions.group.parent',
    'assignedOptions.mainImage',
    'assignedOptions.variants',
]);

    $optionGroups = $product->assignedOptions
        ->where('pivot.is_active', 1)
        ->sortBy(function ($option) {
            $group = $option->group;
            $parent = $group?->parent;

            return [
                $parent->sort_order ?? $group->sort_order ?? 999,
                $group->sort_order ?? 999,
                $option->pivot->sort_order ?? 0,
            ];
        })
        ->groupBy(function ($option) {
            $group = $option->group;
            $displayGroup = $group?->parent ?: $group;

            return $displayGroup?->option_group_id ?? 0;
        });

    $dependencies = OptionDependency::where('is_active', 1)
        ->orderBy('sort_order')
        ->get()
        ->map(function ($dependency) {
            return [
                'parent_option_id' => (int) $dependency->parent_option_id,
                'target_type' => $dependency->target_type,
                'target_group_id' => $dependency->target_group_id ? (int) $dependency->target_group_id : null,
                'target_option_id' => $dependency->target_option_id ? (int) $dependency->target_option_id : null,
            ];
        })
        ->values();
        $priceRules = $product->priceRules
    ->map(function ($rule) {
        return [
            'rule_id' => (int) $rule->rule_id,
            'rule_name' => $rule->rule_name,
            'option_ids' => $rule->options
                ->pluck('option_id')
                ->map(fn ($id) => (int) $id)
                ->values(),
            'tiers' => $rule->tiers
                ->map(function ($tier) {
                    return [
                        'min_qty' => (int) $tier->min_qty,
                        'max_qty' => $tier->max_qty ? (int) $tier->max_qty : null,
                        'unit_price' => (float) $tier->unit_price,
                    ];
                })
                ->values(),
        ];
    })
    ->values();

    return view('products.hotstrap_show', compact(
        'product',
        'optionGroups',
        'dependencies',
        'priceRules'
   
    ));
}

   public function showHotmobily(Product $product)
{
    if ((int) $product->product_type !== 2) {
        abort(404);
    }

    $product->load([
        'mainImage',
        'images',
        'galleryImages',
        'detail',
        'category',
        'material',
        'assignedOptions.group',
        'assignedOptions.mainImage',
    ]);

    $optionGroups = $product->assignedOptions
        ->where('pivot.is_active', 1)
        ->sortBy('pivot.sort_order')
        ->groupBy(function ($option) {
            return $option->group->group_name ?? 'Other';
        });

    return view('products.hotmobily_show', compact('product', 'optionGroups'));
}

   public function description(Product $product)
{
    $product->load([
        'mainImage',
        'images',
        'galleryImages',
        'detail',
        'category',
        'material',
    ]);

    $relatedProducts = Product::with('mainImage')
        ->where('is_active', 1)
        ->where('category_id', $product->category_id)
        ->where('product_id', '!=', $product->product_id)
        ->where('product_type', $product->product_type)
        ->inRandomOrder()
        ->limit(4)
        ->get();

    if ((int) $product->product_type === 1) {
        return view('products.hotstrap_desc', compact('product', 'relatedProducts'));
    }

    if ((int) $product->product_type === 2) {
        return view('products.hotmobily_desc', compact('product', 'relatedProducts'));
    }

    abort(404);
}
}
