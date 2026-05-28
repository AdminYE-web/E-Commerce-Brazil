<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $langKey = $this->getLangKey();

        $keyword = trim($request->input('keyword', ''));
        $productType = $request->input('product_type');
        $categoryIds = $request->input('categories', []);
        $materialIds = $request->input('materials', []);

        $categories = Category::where('language', $langKey)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('category_id', 'desc')
            ->get();

        $materials = Material::where('language', $langKey)
            ->where('is_active', 1)
            ->orderBy('material_name')
            ->get();

        $products = Product::with(['mainImage', 'category', 'material'])
            ->where('language', $langKey)
            ->where('is_active', 1)
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('product_name', 'like', "%{$keyword}%")
                        ->orWhere('product_code', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($keyword) {
                            $categoryQuery->where('category_name', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('material', function ($materialQuery) use ($keyword) {
                            $materialQuery->where('material_name', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($productType, function ($query) use ($productType) {
                $query->where('product_type', $productType);
            })
            ->when(! empty($categoryIds), function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->when(! empty($materialIds), function ($query) use ($materialIds) {
                $query->whereIn('material_id', $materialIds);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        if ($request->ajax() || $request->input('_ajax')) {
            return response()->json([
                'html' => view('products.partials.product_cards', compact('products'))->render(),
                'pagination' => $products->links()->render(),
            ]);
        }

        return view('search.index', compact(
            'products',
            'categories',
            'materials',
            'keyword',
            'productType',
            'categoryIds',
            'materialIds'
        ));
    }
}
