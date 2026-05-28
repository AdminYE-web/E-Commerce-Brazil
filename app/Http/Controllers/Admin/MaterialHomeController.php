<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialHome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialHomeController extends Controller
{
    public function index()
    {
        $items = MaterialHome::with('material')
            ->orderBy('sort_order')
            ->orderBy('material_home_id', 'desc')
            ->paginate(10);

        return view('admin.material_homes.index', compact('items'));
    }

    public function create()
    {
        $materials = Material::orderBy('material_name')->get();

        return view('admin.material_homes.create', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'nullable|exists:materials,material_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('material-homes', 'public');
        }

        MaterialHome::create([
            'material_id' => $request->material_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.material-homes.index')
            ->with('success', 'Material Home created successfully.');
    }

    public function edit(MaterialHome $materialHome)
    {
        $materials = Material::orderBy('material_name')->get();

        return view('admin.material_homes.edit', compact('materialHome', 'materials'));
    }

    public function update(Request $request, MaterialHome $materialHome)
    {
        $request->validate([
            'material_id' => 'nullable|exists:materials,material_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'remove_image' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $imagePath = $materialHome->image_path;

        if ($request->has('remove_image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = null;
        }

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('material-homes', 'public');
        }

        $materialHome->update([
            'material_id' => $request->material_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.material-homes.index')
            ->with('success', 'Material Home updated successfully.');
    }

    public function destroy(MaterialHome $materialHome)
    {
        if ($materialHome->image_path && Storage::disk('public')->exists($materialHome->image_path)) {
            Storage::disk('public')->delete($materialHome->image_path);
        }

        $materialHome->delete();

        return redirect()
            ->route('admin.material-homes.index')
            ->with('success', 'Material Home deleted successfully.');
    }
}
