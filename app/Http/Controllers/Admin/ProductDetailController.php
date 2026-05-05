<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductDetailController extends Controller
{
    public function index()
    {
        $details = ProductDetail::with('product')
            ->orderBy('product_detail_id', 'desc')
            ->paginate(10);

        return view('admin.product_details.index', compact('details'));
    }

   public function create(Request $request)
{
    $selectedProductId = $request->query('product_id');

    if ($selectedProductId) {
        $existingDetail = ProductDetail::where('product_id', $selectedProductId)->first();

        if ($existingDetail) {
            return redirect()->route(
                'admin.product-details.edit',
                $existingDetail->product_detail_id
            );
        }
    }

    $products = Product::where('is_active', 1)
        ->whereDoesntHave('detail')
        ->orderBy('product_name')
        ->get();

    return view('admin.product_details.create', compact('products', 'selectedProductId'));
}
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id|unique:product_details,product_id',
            'sample_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'detail_content' => 'nullable|array',
'detail_content.*.headline' => 'nullable|string|max:255',
'detail_content.*.desc' => 'nullable|string',
'detail_content.*.emoticon' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $sampleImagePath = null;

        if ($request->hasFile('sample_image')) {
            $sampleImagePath = $request->file('sample_image')
                ->store('products/details', 'public');
        }

       ProductDetail::create([
    'product_id' => $request->product_id,
    'sample_image' => $sampleImagePath,
    'detail_content' => $request->detail_content,
    'is_active' => $request->has('is_active') ? 1 : 0,
]);

        return redirect()
            ->route('admin.product-details.index')
            ->with('success', 'เพิ่มรายละเอียดสินค้าเรียบร้อยแล้ว');
    }

    public function edit(ProductDetail $productDetail)
    {
        $products = Product::where('is_active', 1)
            ->orderBy('product_name')
            ->get();

        return view('admin.product_details.edit', [
            'detail' => $productDetail,
            'products' => $products,
        ]);
    }

    public function update(Request $request, ProductDetail $productDetail)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id|unique:product_details,product_id,' . $productDetail->product_detail_id . ',product_detail_id',
            'sample_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
           'detail_content' => 'nullable|array',
    'detail_content.*.headline' => 'nullable|string|max:255',
    'detail_content.*.desc' => 'nullable|string',
    'detail_content.*.emoticon' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $sampleImagePath = $productDetail->sample_image;

        if ($request->hasFile('sample_image')) {
            if ($productDetail->sample_image) {
                Storage::disk('public')->delete($productDetail->sample_image);
            }

            $sampleImagePath = $request->file('sample_image')
                ->store('products/details', 'public');
        }

        $productDetail->update([
            'product_id' => $request->product_id,
            'sample_image' => $sampleImagePath,
            'detail_content' => $request->detail_content,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.product-details.index')
            ->with('success', 'แก้ไขรายละเอียดสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(ProductDetail $productDetail)
    {
        if ($productDetail->sample_image) {
            Storage::disk('public')->delete($productDetail->sample_image);
        }

        $productDetail->delete();

        return redirect()
            ->route('admin.product-details.index')
            ->with('success', 'ลบรายละเอียดสินค้าเรียบร้อยแล้ว');
    }
}