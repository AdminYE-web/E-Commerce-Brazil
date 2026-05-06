<?php

namespace App\Http\Controllers;

use App\Models\ProductListBanner;
use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
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
            ->when(!empty($categoryIds), function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->when(!empty($materialIds), function ($query) use ($materialIds) {
                $query->whereIn('material_id', $materialIds);
            })
            ->orderBy('product_id', 'desc')
            ->paginate(12)
            ->withQueryString();
            if ($request->ajax()) {
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
        'detail',
        'category',
        'material',
    ]);

    return view('products.hotstrap_desc', compact('product'));
}

public function showHotmobily(Product $product)
{
    if ((int) $product->product_type !== 2) {
        abort(404);
    }

    $product->load([
        'mainImage',
        'images',
        'detail',
        'category',
        'material',
    ]);

    return view('products.hotmobily_desc', compact('product'));
}
public function description(Product $product)
{
    $product->load([
        'mainImage',
        'images',
        'detail',
        'category',
        'material',
    ]);

    if ((int) $product->product_type === 1) {
        return view('products.hotstrap_desc', compact('product'));
    }

    if ((int) $product->product_type === 2) {
        return view('products.hotmobily_desc', compact('product'));
    }

    abort(404);
}

}