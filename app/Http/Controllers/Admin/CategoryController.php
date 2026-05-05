<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('category_id', 'desc')->paginate(10);

        return view('admin.categories.index', compact('categories'));
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
            'is_active' => 'nullable|boolean',
        ]);

        Category::create([
            'category_code' => $request->category_code,
            'category_name' => $request->category_name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

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
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'category_code' => $request->category_code,
            'category_name' => $request->category_name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'แก้ไข Category เรียบร้อยแล้ว');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'ลบ Category เรียบร้อยแล้ว');
    }
}