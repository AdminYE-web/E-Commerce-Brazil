<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTemplate;
use Illuminate\Http\Request;

class DesignTemplateController extends Controller
{
    public function index(Request $request)
    {
        $langKey = $this->getLangKey();

        $selectedType = $request->input('type', 2);
        $selectedProductId = $request->input('product_id');
        $selectedSize = $request->input('size');

        /*
        |--------------------------------------------------------------------------
        | Product type tabs
        |--------------------------------------------------------------------------
        */
        $productTypes = [
            1 => [
                'label' => __('product.design_template.product_type_1'),
                'icon' => asset('assets/images/icon/type1.png'),
            ],
            2 => [
                'label' => __('product.design_template.product_type_2'),
                'icon' => asset('assets/images/icon/type2.png'),
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Products ที่มี template เท่านั้น
        |--------------------------------------------------------------------------
        */
        $products = Product::query()
            ->where('language', $langKey)
            ->where('product_type', $selectedType)
            ->where('is_active', 1)
            ->whereHas('templates', function ($query) use ($langKey) {
                $query->where('language', $langKey)
                    ->where('is_active', 1);
            })
            ->orderBy('product_name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ถ้ายังไม่ได้เลือก product ให้เลือกตัวแรกอัตโนมัติ
        |--------------------------------------------------------------------------
        */
        if (!$selectedProductId && $products->count() > 0) {
            $selectedProductId = $products->first()->product_id;
        }

        /*
        |--------------------------------------------------------------------------
        | Sizes ของ product ที่เลือก
        |--------------------------------------------------------------------------
        */
        $sizes = collect();

        if ($selectedProductId) {
            $sizes = ProductTemplate::query()
                ->where('language', $langKey)
                ->where('is_active', 1)
                ->where('product_id', $selectedProductId)
                ->whereNotNull('template_size')
                ->where('template_size', '!=', '')
                ->select('template_size')
                ->distinct()
                ->orderBy('template_size')
                ->pluck('template_size');
        }

        if (!$selectedSize && $sizes->count() > 0) {
            $selectedSize = $sizes->first();
        }

        /*
        |--------------------------------------------------------------------------
        | ถ้ายังไม่ได้เลือก size ให้เลือกตัวแรกอัตโนมัติ
        |--------------------------------------------------------------------------
        */
        if (!$selectedSize && $sizes->count() > 0) {
            $selectedSize = $sizes->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Templates result
        |--------------------------------------------------------------------------
        */
        $templates = ProductTemplate::with('product')
            ->where('language', $langKey)
            ->where('is_active', 1)
            ->when($selectedProductId, function ($query) use ($selectedProductId) {
                $query->where('product_id', $selectedProductId);
            })
            ->when($sizes->count() > 0 && $selectedSize, function ($query) use ($selectedSize) {
                $query->where('template_size', $selectedSize);
            })
            ->when($sizes->count() === 0, function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('template_size')
                        ->orWhere('template_size', '');
                });
            })
            ->orderBy('file_type')
            ->orderBy('original_name')
            ->get();

        return view('design-template.index', compact(
            'productTypes',
            'selectedType',
            'selectedProductId',
            'selectedSize',
            'products',
            'sizes',
            'templates',
            'langKey'
        ));
    }
}
