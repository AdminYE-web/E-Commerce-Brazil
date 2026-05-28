<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $language = session('admin_product_language', 'pt');

        $products = Product::with(['category', 'material'])
            ->where('language', $language)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', '%'.$search.'%')
                        ->orWhere('product_code', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('product_id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search', 'language'));
    }

    public function create()
    {
        $language = session('admin_product_language', 'pt');

        $categories = Category::where('is_active', 1)
            ->where('language', $language)
            ->orderBy('category_name')
            ->get();

        $materials = Material::where('is_active', 1)
            ->where('language', $language)
            ->orderBy('material_name')
            ->get();

        return view('admin.products.create', compact('categories', 'materials', 'language'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,category_id',
            'material_id' => 'nullable|exists:materials,material_id',
            'product_type' => 'required|integer|in:1,2',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_antivirus_included' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'product_recomend' => 'nullable|boolean',
            'product_premium' => 'nullable|boolean',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'can_upload_artwork' => 'nullable|boolean',
            'artwork_required' => 'nullable|boolean',
            'allow_no_artwork' => 'nullable|boolean',
            'allow_text_print' => 'nullable|boolean',
            'allow_font_select' => 'nullable|boolean',
            'allow_template_select' => 'nullable|boolean',
            'translation_key' => 'nullable|string|max:255',
        ]);
        $language = session('admin_product_language', 'pt');

        $product = Product::create([
            'product_code' => $request->product_code,
            'category_id' => $request->category_id,
            'material_id' => $request->material_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'language' => $language,
            'is_antivirus_included' => $request->has('is_antivirus_included') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'product_recomend' => $request->has('product_recomend') ? 1 : 0,
            'product_premium' => $request->has('product_premium') ? 1 : 0,
            'product_type' => $request->product_type,
            'can_upload_artwork' => $request->has('can_upload_artwork') ? 1 : 0,
            'artwork_required' => $request->has('artwork_required') ? 1 : 0,
            'allow_no_artwork' => $request->has('allow_no_artwork') ? 1 : 0,
            'allow_text_print' => $request->has('allow_text_print') ? 1 : 0,
            'allow_font_select' => $request->has('allow_font_select') ? 1 : 0,
            'allow_template_select' => $request->has('allow_template_select') ? 1 : 0,
            'translation_key' => $request->translation_key ?: $request->product_code,
        ]);

        // Main images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->product_id,
                    'image_path' => $path,
                    'image_alt' => $product->product_name,
                    'image_type' => 'main',
                    'is_main' => $index === 0 ? 1 : 0,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        // Gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->product_id,
                    'image_path' => $path,
                    'image_alt' => $product->product_name,
                    'image_type' => 'gallery',
                    'is_main' => 0,
                    'sort_order' => $index + 1,
                ]);
            }
        }
        Cache::forget('home_page_data_'.$language);
        Cache::forget('home_page_data');

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'galleryImages']);

        $language = $product->language ?? session('admin_product_language', 'pt');

        $categories = Category::where('is_active', 1)
            ->where('language', $language)
            ->orderBy('category_name')
            ->get();

        $materials = Material::where('is_active', 1)
            ->where('language', $language)
            ->orderBy('material_name')
            ->get();

        return view('admin.products.edit', compact('product', 'categories', 'materials', 'language'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,category_id',
            'material_id' => 'nullable|exists:materials,material_id',
            'main_image_id' => 'nullable|exists:product_images,image_id',
            'product_type' => 'required|integer|in:1,2',
            'product_name' => 'required|string|max:255',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'is_antivirus_included' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'product_recomend' => 'nullable|boolean',
            'product_premium' => 'nullable|boolean',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'can_upload_artwork' => 'nullable|boolean',
            'artwork_required' => 'nullable|boolean',
            'allow_no_artwork' => 'nullable|boolean',
            'allow_text_print' => 'nullable|boolean',
            'allow_font_select' => 'nullable|boolean',
            'allow_template_select' => 'nullable|boolean',
            'delete_gallery_images' => 'nullable|array',
            'delete_gallery_images.*' => 'integer',
            'translation_key' => 'nullable|string|max:255',

        ]);

        $product->update([
            'product_code' => $request->product_code,
            'category_id' => $request->category_id,
            'material_id' => $request->material_id,
            'language' => session('admin_product_language', $product->language ?? 'pt'),
            'product_type' => $request->product_type,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'is_antivirus_included' => $request->has('is_antivirus_included') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'product_recomend' => $request->has('product_recomend') ? 1 : 0,
            'product_premium' => $request->has('product_premium') ? 1 : 0,
            'can_upload_artwork' => $request->has('can_upload_artwork') ? 1 : 0,
            'artwork_required' => $request->has('artwork_required') ? 1 : 0,
            'allow_no_artwork' => $request->has('allow_no_artwork') ? 1 : 0,
            'allow_text_print' => $request->has('allow_text_print') ? 1 : 0,
            'allow_font_select' => $request->has('allow_font_select') ? 1 : 0,
            'allow_template_select' => $request->has('allow_template_select') ? 1 : 0,
            'translation_key' => $request->translation_key ?: $product->translation_key ?: $product->product_code,
        ]);
        if ($request->filled('delete_gallery_images')) {
            $galleryImages = ProductImage::where('product_id', $product->product_id)
                ->where('image_type', 'gallery')
                ->whereIn('image_id', $request->delete_gallery_images)
                ->get();

            foreach ($galleryImages as $galleryImage) {
                if ($galleryImage->image_path && Storage::disk('public')->exists($galleryImage->image_path)) {
                    Storage::disk('public')->delete($galleryImage->image_path);
                }

                $galleryImage->delete();
            }
        }
        if ($request->filled('main_image_id')) {
            $product->images()->update([
                'is_main' => 0,
            ]);

            $product->images()
                ->where('image_id', $request->main_image_id)
                ->update([
                    'is_main' => 1,
                    'image_type' => 'main',
                ]);
        }

        if ($request->hasFile('images')) {
            $currentMaxSort = $product->images()->max('sort_order') ?? 0;
            $hasMainImage = $product->images()->where('is_main', 1)->exists();

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->product_id,
                    'image_path' => $path,
                    'image_type' => 'main',
                    'image_alt' => $product->product_name,
                    'is_main' => ! $hasMainImage && $index === 0 ? 1 : 0,
                    'sort_order' => $currentMaxSort + $index + 1,
                ]);
            }
        }
        if ($request->hasFile('gallery_images')) {
            $currentMaxSort = $product->galleryImages()->max('sort_order') ?? 0;

            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->product_id,
                    'image_path' => $path,
                    'image_alt' => $product->product_name,
                    'image_type' => 'gallery',
                    'is_main' => 0,
                    'sort_order' => $currentMaxSort + $index + 1,
                ]);
            }
        }
        $language = $product->language;
        Cache::forget('home_page_data_'.$language);
        Cache::forget('home_page_data');

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        $language = $product->language;
        Cache::forget('home_page_data_'.$language);
        Cache::forget('home_page_data');

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
