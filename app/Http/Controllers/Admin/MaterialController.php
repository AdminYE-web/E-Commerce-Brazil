<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $language = session('admin_product_language', 'pt');

        $materials = Material::query()
            ->where('language', $language)
            ->when($search, function ($query) use ($search) {
                $query->where('material_name', 'like', '%'.$search.'%');
            })
            ->orderBy('material_id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.materials.index', compact('materials', 'search', 'language'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_code' => 'nullable|string|max:100',
            'material_name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Material::create([
            'material_code' => $request->material_code,
            'material_name' => $request->material_name,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'language' => session('admin_product_language', 'pt'),
        ]);

        Cache::forget('home_page_data');
        Cache::forget('product_list_shared_components_pt');
        Cache::forget('product_list_shared_components_ja');
        Cache::forget('product_list_shared_components_en');
        Cache::forget('product_list_shared_components');

        return redirect()
            ->route('admin.materials.index')
            ->with('success', 'เพิ่ม Material เรียบร้อยแล้ว');
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'material_code' => 'nullable|string|max:100',
            'material_name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $material->update([
            'material_code' => $request->material_code,
            'material_name' => $request->material_name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        Cache::forget('home_page_data');
        Cache::forget('product_list_shared_components_pt');
        Cache::forget('product_list_shared_components_ja');
        Cache::forget('product_list_shared_components_en');
        Cache::forget('product_list_shared_components');

        return redirect()
            ->route('admin.materials.index')
            ->with('success', 'แก้ไข Material เรียบร้อยแล้ว');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        Cache::forget('home_page_data');
        Cache::forget('product_list_shared_components_pt');
        Cache::forget('product_list_shared_components_ja');
        Cache::forget('product_list_shared_components_en');
        Cache::forget('product_list_shared_components');

        return redirect()
            ->route('admin.materials.index')
            ->with('success', 'ลบ Material เรียบร้อยแล้ว');
    }
}
