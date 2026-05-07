<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use App\Models\OptionImage;

class ProductOptionController extends Controller
{
    public function index()
    {
      $options = ProductOption::with(['group', 'mainImage'])
    ->orderBy('option_id', 'desc')
    ->paginate(10);

        return view('admin.product_options.index', compact('options'));
    }

    public function create()
    {
        $groups = OptionGroup::where('is_active', 1)
            ->orderBy('group_name')
            ->get();

        return view('admin.product_options.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'option_group_id' => 'required|exists:option_groups,option_group_id',
            'option_code' => 'nullable|string|max:100',
            'option_name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:20',
            'additional_price' => 'required|numeric|min:0',
            'price_type' => 'required|in:per_item,per_order',
            'option_detail' => 'nullable|string',
            
        ]);

      $option = ProductOption::create([
    'option_group_id' => $request->option_group_id,
    'option_code' => $request->option_code,
    'option_name' => $request->option_name,
    'color_code' => $request->color_code,
    'additional_price' => $request->additional_price,
    'price_type' => $request->price_type,
    'is_active' => $request->has('is_active') ? 1 : 0,
    'option_detail' => $request->option_detail,
    
]);
if ($request->hasFile('images')) {
    foreach ($request->file('images') as $index => $image) {
        $path = $image->store('options', 'public');

        OptionImage::create([
            'option_id' => $option->option_id,
            'image_path' => $path,
            'image_alt' => $option->option_name,
            'is_main' => $index === 0 ? 1 : 0,
            'sort_order' => $index + 1,
        ]);
    }
}

        return redirect()
            ->route('admin.product-options.index')
            ->with('success', 'เพิ่มตัวเลือกสินค้าเรียบร้อยแล้ว');
    }

   public function edit(ProductOption $productOption)
{
    $groups = OptionGroup::where('is_active', 1)
        ->orderBy('group_name')
        ->get();

    $productOption->load('images');

    return view('admin.product_options.edit', [
        'option' => $productOption,
        'groups' => $groups,
    ]);
}

    public function update(Request $request, ProductOption $productOption)
    {
        $request->validate([
            'option_group_id' => 'required|exists:option_groups,option_group_id',
            'option_code' => 'nullable|string|max:100',
            'option_name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:20',
            'additional_price' => 'required|numeric|min:0',
            'price_type' => 'required|in:per_item,per_order',
           'option_detail' => 'nullable|string',
        ]);

        $productOption->update([
            'option_group_id' => $request->option_group_id,
            'option_code' => $request->option_code,
            'option_name' => $request->option_name,
            'color_code' => $request->color_code,
            'additional_price' => $request->additional_price,
            'price_type' => $request->price_type,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'option_detail' => $request->option_detail,
        ]);
        if ($request->hasFile('images')) {
    $currentMaxSort = $productOption->images()->max('sort_order') ?? 0;
    $hasMainImage = $productOption->images()->where('is_main', 1)->exists();

    foreach ($request->file('images') as $index => $image) {
        $path = $image->store('options', 'public');

        OptionImage::create([
            'option_id' => $productOption->option_id,
            'image_path' => $path,
            'image_alt' => $productOption->option_name,
            'is_main' => !$hasMainImage && $index === 0 ? 1 : 0,
            'sort_order' => $currentMaxSort + $index + 1,
        ]);
    }
}

        return redirect()
            ->route('admin.product-options.index')
            ->with('success', 'แก้ไขตัวเลือกสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(ProductOption $productOption)
    {
        $productOption->delete();

        return redirect()
            ->route('admin.product-options.index')
            ->with('success', 'ลบตัวเลือกสินค้าเรียบร้อยแล้ว');
    }
}