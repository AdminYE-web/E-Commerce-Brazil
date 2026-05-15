<?php

namespace App\Http\Controllers;

use App\Models\HomeBanner;
use App\Models\MaterialHome;
use App\Models\Product;
use Illuminate\Support\Facades\Cache; // เพิ่มสิ่งนี้
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
{
    // 1. User เฉพาะบุคคล ไม่ cache
    $user = Auth::user();

    // 2. ดึงภาษาปัจจุบัน เช่น pt, ja, en
    $langKey = $this->getLangKey();

    // 3. ทำ cache key แยกตามภาษา
    $cacheKey = 'home_page_data_' . $langKey;

    // 4. Cache ข้อมูลตามภาษา
    $homeData = Cache::remember($cacheKey, 3600, function () use ($langKey) {
        return [
            'recommendedProducts' => Product::with(['mainImage', 'category'])
                ->where('language', $langKey)
                ->where('product_recomend', 1)
                ->where('is_active', 1)
                ->orderBy('updated_at', 'desc')
                ->take(12)
                ->get(),

            'recommendedType1Products' => Product::with(['mainImage'])
                ->where('language', $langKey)
                ->where('product_recomend', 1)
                ->where('product_type', 1)
                ->where('is_active', 1)
                ->orderBy('updated_at', 'desc')
                ->take(12)
                ->get(),

            'recommendedType2Products' => Product::with(['mainImage'])
                ->where('language', $langKey)
                ->where('product_recomend', 1)
                ->where('product_type', 2)
                ->where('is_active', 1)
                ->orderBy('updated_at', 'desc')
                ->take(12)
                ->get(),

            'materialHomes' => MaterialHome::with(['material' => function ($query) use ($langKey) {
                    $query->where('language', $langKey);
                }])
                ->where('is_active', 1)
                ->orderBy('sort_order')
                ->get(),

            'homeBanners' => HomeBanner::where('is_active', 1)
                ->orderBy('sort_order')
                ->orderBy('home_banner_id', 'desc')
                ->get(),
        ];
    });

    return view('home', array_merge([
        'user' => $user,
        'langKey' => $langKey,
    ], $homeData));
}
}