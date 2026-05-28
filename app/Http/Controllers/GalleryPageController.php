<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryBanner;
use App\Models\Material;
use Illuminate\Http\Request;

class GalleryPageController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        $materialId = $request->input('material_id');
        $purpose = $request->input('purpose');
        $sort = $request->input('sort', 'newest');

        $categories = Category::orderBy('category_name')->get();
        $materials = Material::orderBy('material_name')->get();

        $purposes = Gallery::where('is_active', 1)
            ->whereNotNull('purpose')
            ->where('purpose', '!=', '')
            ->select('purpose')
            ->distinct()
            ->orderBy('purpose')
            ->pluck('purpose');

        $galleries = Gallery::with(['category', 'material'])
            ->where('is_active', 1)
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($materialId, function ($query) use ($materialId) {
                $query->where('material_id', $materialId);
            })
            ->when($purpose, function ($query) use ($purpose) {
                $query->where('purpose', $purpose);
            });
        $galleryBanners = GalleryBanner::where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('gallery_banner_id', 'desc')
            ->get();

        if ($sort === 'oldest') {
            $galleries->orderBy('gallery_date', 'asc')
                ->orderBy('gallery_id', 'asc');
        } else {
            $galleries->orderBy('gallery_date', 'desc')
                ->orderBy('gallery_id', 'desc');
        }

        $galleries = $galleries->paginate(12)->withQueryString();

        return view('gallery.index', compact(
            'galleries',
            'categories',
            'materials',
            'purposes',
            'categoryId',
            'materialId',
            'purpose',
            'sort',
            'galleryBanners'
        ));
    }
}
