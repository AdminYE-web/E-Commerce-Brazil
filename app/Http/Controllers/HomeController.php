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
        // 1. แยกส่วน User ออกมา (ไม่ต้อง Cache เพราะเป็นข้อมูลเฉพาะบุคคล)
        $user = Auth::user();

        // 2. ใช้ Cache หุ้มส่วนการดึงข้อมูลที่ใช้ร่วมกันทุกคน
        // ตั้งชื่อ Key ว่า 'home_data' และเก็บไว้ 60 นาที (3600 วินาที)
        $homeData = Cache::remember('home_page_data', 3600, function () {
            return [
                'recommendedProducts' => Product::with(['mainImage', 'category'])
                    ->where('product_recomend', 1)
                    ->where('is_active', 1)
                    ->orderBy('updated_at', 'desc')
                    ->take(12)
                    ->get(),

                'recommendedType1Products' => Product::with(['mainImage'])
                    ->where('product_recomend', 1)
                    ->where('product_type', 1)
                    ->where('is_active', 1)
                    ->orderBy('updated_at', 'desc')
                    ->take(12)
                    ->get(),

                'recommendedType2Products' => Product::with(['mainImage'])
                    ->where('product_recomend', 1)
                    ->where('product_type', 2)
                    ->where('is_active', 1)
                    ->orderBy('updated_at', 'desc')
                    ->take(12)
                    ->get(),

                'materialHomes' => MaterialHome::with('material')
                    ->where('is_active', 1)
                    ->orderBy('sort_order')
                    ->get(),

                'homeBanners' => HomeBanner::where('is_active', 1)
                    ->orderBy('sort_order')
                    ->orderBy('home_banner_id', 'desc')
                    ->get(),
            ];
        });

        // 3. ส่งข้อมูลออกไปที่ View
        return view('home', array_merge(['user' => $user], $homeData));
    }
}