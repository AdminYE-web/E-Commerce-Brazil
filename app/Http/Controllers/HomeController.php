<?php

namespace App\Http\Controllers;
use App\Models\HomeBanner;
use App\Models\MaterialHome;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $recommendedProducts = Product::with(['mainImage', 'category'])
        ->where('product_recomend', 1)
        ->where('is_active', 1)
        ->orderBy('updated_at', 'desc')
        ->take(12)
        ->get();
          $recommendedType1Products = Product::with(['mainImage'])
        ->where('product_recomend', 1)
        ->where('product_type', 1)
        ->where('is_active', 1)
        ->orderBy('updated_at', 'desc')
        ->take(12)
        ->get();
          $recommendedType2Products = Product::with(['mainImage'])
        ->where('product_recomend', 1)
        ->where('product_type', 2)
        ->where('is_active', 1)
        ->orderBy('updated_at', 'desc')
        ->take(12)
        ->get();
        $materialHomes = MaterialHome::with('material')
    ->where('is_active', 1)
    ->orderBy('sort_order')
    ->get();
     $homeBanners = HomeBanner::where('is_active', 1)
        ->orderBy('sort_order')
        ->orderBy('home_banner_id', 'desc')
        ->get();


    return view('home', compact('recommendedProducts', 'recommendedType1Products', 'recommendedType2Products', 'materialHomes', 'homeBanners'));
    }
}
