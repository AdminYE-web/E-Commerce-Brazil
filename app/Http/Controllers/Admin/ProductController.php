<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['mainImage', 'detail', 'category', 'material'])
            ->orderBy('product_id', 'desc')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)
            ->orderBy('category_name')
            ->get();

        $materials = Material::where('is_active', 1)
            ->orderBy('material_name')
            ->get();

        return view('admin.products.create', compact('categories', 'materials'));
    }

  public function store(Request $request)
{
    $request->validate([
        'product_code' => 'nullable|string|max:100',
        'category_id' => 'nullable|exists:categories,category_id',
        'material_id' => 'nullable|exists:materials,material_id',
        'product_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_antivirus_included' => 'nullable|boolean',
        'is_active' => 'nullable|boolean',

        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $product = Product::create([
        'product_code' => $request->product_code,
        'category_id' => $request->category_id,
        'material_id' => $request->material_id,
        'product_name' => $request->product_name,
        'description' => $request->description,
        'is_antivirus_included' => $request->has('is_antivirus_included') ? 1 : 0,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->product_id,
                'image_path' => $path,
                'image_alt' => $product->product_name,
                'is_main' => $index === 0 ? 1 : 0,
                'sort_order' => $index + 1,
            ]);
        }
    }

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Product created successfully.');
}

    public function edit(Product $product)
{
    $product->load('images');

    $categories = Category::where('is_active', 1)
        ->orderBy('category_name')
        ->get();

    $materials = Material::where('is_active', 1)
        ->orderBy('material_name')
        ->get();

    return view('admin.products.edit', compact('product', 'categories', 'materials'));
}

    public function update(Request $request, Product $product)
{
    $request->validate([
        'product_code' => 'nullable|string|max:100',
        'category_id' => 'nullable|exists:categories,category_id',
        'material_id' => 'nullable|exists:materials,material_id',
        'product_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_antivirus_included' => 'nullable|boolean',
        'is_active' => 'nullable|boolean',

        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $product->update([
        'product_code' => $request->product_code,
        'category_id' => $request->category_id,
        'material_id' => $request->material_id,
        'product_name' => $request->product_name,
        'description' => $request->description,
        'is_antivirus_included' => $request->has('is_antivirus_included') ? 1 : 0,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    if ($request->hasFile('images')) {
        $currentMaxSort = $product->images()->max('sort_order') ?? 0;
        $hasMainImage = $product->images()->where('is_main', 1)->exists();

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->product_id,
                'image_path' => $path,
                'image_alt' => $product->product_name,
                'is_main' => !$hasMainImage && $index === 0 ? 1 : 0,
                'sort_order' => $currentMaxSort + $index + 1,
            ]);
        }
    }

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Product updated successfully.');
}

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id')
            ->where('is_main', 1);
    }
}
