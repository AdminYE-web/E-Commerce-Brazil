<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
    $language = session('admin_product_language', 'pt');

    $categories = Category::query()
        ->where('language', $language)
        ->when($search, function ($query) use ($search) {
            $query->where('category_name', 'like', '%' . $search . '%');
        })
        ->orderBy('sort_order')
        ->orderBy('category_id', 'desc')
        ->paginate(15)
        ->withQueryString();

    return view('admin.categories.index', compact('categories', 'search', 'language'));
}

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'category_code' => 'nullable|string|max:100',
        'category_name' => 'required|string|max:255',
        'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'sort_order' => 'nullable|integer|min:0',
        'is_active' => 'nullable|boolean',
    ]);

    $imagePath = null;

    if ($request->hasFile('image_path')) {
        $imagePath = $request->file('image_path')
            ->store('categories', 'public');
    }

    Category::create([
        'category_code' => $request->category_code,
        'category_name' => $request->category_name,
        'image_path' => $imagePath,
        'sort_order' => $request->sort_order ?? 0,
        'is_active' => $request->has('is_active') ? 1 : 0,
        'language' => session('admin_product_language', 'pt'),
    ]);

    Cache::forget('product_list_shared_components_pt');
    Cache::forget('product_list_shared_components_ja');
    Cache::forget('product_list_shared_components_en');
    Cache::forget('product_list_shared_components');

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'เพิ่ม Category เรียบร้อยแล้ว');
}
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    $request->validate([
        'category_code' => 'nullable|string|max:100',
        'category_name' => 'required|string|max:255',
        'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'sort_order' => 'nullable|integer|min:0',
        'is_active' => 'nullable|boolean',
    ]);

    $imagePath = $category->image_path;

    if ($request->hasFile('image_path')) {
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        $imagePath = $request->file('image_path')
            ->store('categories', 'public');
    }

    $category->update([
        'category_code' => $request->category_code,
        'category_name' => $request->category_name,
        'image_path' => $imagePath,
        'sort_order' => $request->sort_order ?? 0,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    Cache::forget('product_list_shared_components_pt');
Cache::forget('product_list_shared_components_ja');
Cache::forget('product_list_shared_components_en');
Cache::forget('product_list_shared_components');

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'แก้ไข Category เรียบร้อยแล้ว');
}

    public function destroy(Category $category)
{
    if ($category->image_path) {
        Storage::disk('public')->delete($category->image_path);
    }

    $category->delete();

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'ลบ Category เรียบร้อยแล้ว');
}
}