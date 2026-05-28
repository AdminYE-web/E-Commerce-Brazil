<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.public', function () {
            return base_path();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('partials.header', function ($view) {
            $langKey = session('locale', app()->getLocale());
            $fallbackLang = 'pt';

            $megaType1Products = Product::query()
                ->where('product_type', 1)
                ->where('language', $langKey)
                ->where('is_active', 1)
                ->orderBy('product_name')
                ->limit(12)
                ->get();

            $megaType2Products = Product::query()
                ->where('product_type', 2)
                ->where('language', $langKey)
                ->where('is_active', 1)
                ->orderBy('product_name')
                ->limit(12)
                ->get();

            // fallback ถ้าภาษาปัจจุบันไม่มีสินค้า
            if ($megaType1Products->isEmpty() && $langKey !== $fallbackLang) {
                $megaType1Products = Product::query()
                    ->where('product_type', 1)
                    ->where('language', $fallbackLang)
                    ->where('is_active', 1)
                    ->orderBy('product_name')
                    ->limit(12)
                    ->get();
            }

            if ($megaType2Products->isEmpty() && $langKey !== $fallbackLang) {
                $megaType2Products = Product::query()
                    ->where('product_type', 2)
                    ->where('language', $fallbackLang)
                    ->where('is_active', 1)
                    ->orderBy('product_name')
                    ->limit(12)
                    ->get();
            }
            $megaRecommendType1Products = Product::query()
                ->with(['mainImage', 'detail'])
                ->where('product_type', 1)
                ->where('product_recomend', 1)
                ->where('language', $langKey)
                ->where('is_active', 1)
                ->orderBy('product_name')
                ->limit(1)
                ->get();
            $megaRecommendType2Products = Product::query()
                ->with(['mainImage', 'detail'])
                ->where('product_type', 2)
                ->where('product_recomend', 1)
                ->where('language', $langKey)
                ->where('is_active', 1)
                ->orderBy('product_name')
                ->limit(1)
                ->get();

            $view->with([
                'megaType1Products' => $megaType1Products,
                'megaType2Products' => $megaType2Products,
                'megaRecommendType1Products' => $megaRecommendType1Products,
                'megaRecommendType2Products' => $megaRecommendType2Products,

            ]);
        });
    }
}
