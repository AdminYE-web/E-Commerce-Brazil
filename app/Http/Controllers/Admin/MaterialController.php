<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('material_id', 'desc')->paginate(10);

        return view('admin.materials.index', compact('materials'));
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
        ]);

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

        return redirect()
            ->route('admin.materials.index')
            ->with('success', 'แก้ไข Material เรียบร้อยแล้ว');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()
            ->route('admin.materials.index')
            ->with('success', 'ลบ Material เรียบร้อยแล้ว');
    }
}