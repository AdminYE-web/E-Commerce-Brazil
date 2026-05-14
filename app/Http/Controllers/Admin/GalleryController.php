<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $galleries = Gallery::with(['category', 'material', 'images'])
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('purpose', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('category_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('material', function ($q) use ($search) {
                        $q->where('material_name', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('sort_order')
            ->orderBy('gallery_id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.galleries.index', compact('galleries', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        $materials = Material::orderBy('material_name')->get();

        return view('admin.galleries.create', compact('categories', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,category_id'],
            'material_id' => ['nullable', 'exists:materials,material_id'],
            'purpose' => ['nullable', 'string'],
            'gallery_date' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'product_link' => ['nullable', 'string', 'max:255'],
        ]);

        $coverImagePath = null;

        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('galleries/covers', 'public');
        }

        $gallery = Gallery::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'material_id' => $request->material_id,
            'purpose' => $request->purpose,
            'gallery_date' => $request->gallery_date,
            'cover_image' => $coverImagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'product_link' => $request->product_link,
        ]);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('galleries/images', 'public');

                GalleryImage::create([
                    'gallery_id' => $gallery->gallery_id,
                    'image_path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Gallery created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load(['images', 'category', 'material']);

        $categories = Category::orderBy('category_name')->get();
        $materials = Material::orderBy('material_name')->get();

        return view('admin.galleries.edit', compact('gallery', 'categories', 'materials'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,category_id'],
            'material_id' => ['nullable', 'exists:materials,material_id'],
            'purpose' => ['nullable', 'string'],
            'gallery_date' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'delete_gallery_images' => ['nullable', 'array'],
            'delete_gallery_images.*' => ['integer'],
            'remove_cover_image' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'product_link' => ['nullable', 'string', 'max:255'],
        ]);

        $coverImagePath = $gallery->cover_image;

        if ($request->has('remove_cover_image')) {
            if ($coverImagePath && Storage::disk('public')->exists($coverImagePath)) {
                Storage::disk('public')->delete($coverImagePath);
            }

            $coverImagePath = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($coverImagePath && Storage::disk('public')->exists($coverImagePath)) {
                Storage::disk('public')->delete($coverImagePath);
            }

            $coverImagePath = $request->file('cover_image')->store('galleries/covers', 'public');
        }

        $gallery->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'material_id' => $request->material_id,
            'purpose' => $request->purpose,
            'gallery_date' => $request->gallery_date,
            'cover_image' => $coverImagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'product_link' => $request->product_link,
        ]);

        if ($request->filled('delete_gallery_images')) {
            $imagesToDelete = GalleryImage::where('gallery_id', $gallery->gallery_id)
                ->whereIn('gallery_image_id', $request->delete_gallery_images)
                ->get();

            foreach ($imagesToDelete as $image) {
                if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }

                $image->delete();
            }
        }

        if ($request->hasFile('gallery_images')) {
            $startSort = GalleryImage::where('gallery_id', $gallery->gallery_id)->max('sort_order') ?? 0;

            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('galleries/images', 'public');

                GalleryImage::create([
                    'gallery_id' => $gallery->gallery_id,
                    'image_path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                    'sort_order' => $startSort + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('admin.galleries.edit', $gallery->gallery_id)
            ->with('success', 'Gallery updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        foreach ($gallery->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $gallery->delete();

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Gallery deleted successfully.');
    }
}