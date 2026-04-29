<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('product_id', 'desc')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:100',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_antivirus_included' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        Product::create([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'is_antivirus_included' => $request->has('is_antivirus_included') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:100',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_antivirus_included' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $product->update([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'is_antivirus_included' => $request->has('is_antivirus_included') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

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
}
