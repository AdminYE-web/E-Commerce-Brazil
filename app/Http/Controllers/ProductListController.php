<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Material;
use App\Models\OptionDependency;
use App\Models\Product;
use App\Models\ProductListBanner;
use App\Models\ProductOptionGroupOrder;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        $categoryIds = $request->input('categories', []);
        $materialIds = $request->input('materials', []);
        $productType = (int) $request->input('product_type', 1);

        if (! in_array($productType, [1, 2], true)) {
            $productType = 1;
        }

        $langKey = $this->getLangKey();

        $sharedData = Cache::remember(
            'product_list_shared_components_'.$langKey.'_type_'.$productType,
            86400,
            function () use ($langKey, $productType) {
                return [
                    'banners' => ProductListBanner::where('is_active', 1)
                        ->orderBy('sort_order')
                        ->orderBy('banner_id', 'desc')
                        ->get(),

                    'categories' => Category::where('is_active', 1)
                        ->where('language', $langKey)
                        ->where('product_type', $productType)
                        ->orderBy('category_name', 'asc')
                        ->get(),

                    'materials' => Material::where('is_active', 1)
                        ->where('language', $langKey)
                        ->where('product_type', $productType)
                        ->orderBy('material_name')
                        ->get(),
                ];
            }
        );

        $banners = $sharedData['banners'];
        $categories = $sharedData['categories'];
        $materials = $sharedData['materials'];

        $products = Product::with([
            'mainImage',
            'category',
            'material',
            'detail',
            'displayPriceTier',
        ])
            ->where('language', $langKey)
            ->where('is_active', 1)
            ->where('product_type', $productType)
            ->when(! empty($categoryIds), function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->when(! empty($materialIds), function ($query) use ($materialIds) {
                $query->whereIn('material_id', $materialIds);
            })
            ->orderBy('product_id', 'desc')
            ->paginate(12)
            ->withQueryString();

        if ($request->ajax() && $request->input('_ajax') == 1) {
            return response()->json([
                'html' => view('products.partials.product_cards', compact('products'))->render(),
                'pagination' => $products->links()->render(),
            ]);
        }

        return view('products.index', compact(
            'products',
            'categories',
            'materials',
            'categoryIds',
            'materialIds',
            'productType',
            'banners',
            'langKey'
        ));
    }

    public function show(Product $product)
    {
        $product->load(['mainImage', 'images', 'detail', 'category', 'material']);

        return view('products.desc', compact('product'));
    }

    public function showHotstrap(Product $product)
    {
        $langKey = $this->getLangKey();

        $priceTaxMode = Cache::remember('system_setting_price_tax_mode', 3600, function () {
            return SystemSetting::getValue('price_tax_mode', 'exclude_tax');
        });

        $useTaxIncludedPrice = $priceTaxMode === 'include_tax';

        /*
    |--------------------------------------------------------------------------
    | Redirect to translated product if current product language is different
    |--------------------------------------------------------------------------
    */
        if ($product->language !== $langKey && ! empty($product->translation_key)) {
            $translatedProduct = Product::where('translation_key', $product->translation_key)
                ->where('language', $langKey)
                ->where('is_active', 1)
                ->where('product_type', 1)
                ->first();

            if ($translatedProduct) {
                return redirect()->route('products.hotstrap.show', $translatedProduct->product_id);
            }
        }

        if ((int) $product->product_type !== 1) {
            abort(404);
        }

        if ($product->language !== $langKey) {
            session(['locale' => $product->language]);
            app()->setLocale($product->language);

            return redirect()
                ->route('products.hotstrap.show', $product->product_id)
                ->with('translation_unavailable', 'สินค้าตัวนี้ยังไม่พร้อมสำหรับภาษาที่เลือก');
        }

        $product->load([
            'mainImage',
            'images',
            'galleryImages',
            'detail',
            'category',
            'material',

            'priceRules.options',
            'priceRules.tiers',

            'assignedOptions.group.parent',
            'assignedOptions.mainImage',
            'assignedOptions.variants',
        ]);

        $groupOrders = ProductOptionGroupOrder::where('product_id', $product->product_id)
            ->pluck('sort_order', 'option_group_id');

        $optionGroups = $product->assignedOptions
            ->where('pivot.is_active', 1)
            ->filter(function ($option) use ($langKey) {
                return $option->language === $langKey
                    && $option->group
                    && $option->group->language === $langKey;
            })
            ->sortBy(function ($option) use ($groupOrders) {
                $group = $option->group;
                $parent = $group?->parent;

                $displayGroup = $parent ?: $group;
                $displayGroupId = $displayGroup?->option_group_id;

                return [
                    $groupOrders[$displayGroupId] ?? 999,
                    $parent->sort_order ?? $group->sort_order ?? 999,
                    $group->sort_order ?? 999,
                    $option->pivot->sort_order ?? 0,
                ];
            })
            ->groupBy(function ($option) {
                $group = $option->group;
                $displayGroup = $group?->parent ?: $group;

                return $displayGroup?->option_group_id ?? 0;
            });

        $dependencies = OptionDependency::where('is_active', 1)
            ->whereHas('parentOption', function ($query) use ($langKey) {
                $query->where('language', $langKey);
            })
            ->orderBy('sort_order')
            ->get()
            ->map(function ($dependency) {
                return [
                    'parent_option_id' => (int) $dependency->parent_option_id,
                    'target_type' => $dependency->target_type,
                    'action_type' => $dependency->action_type ?? 'show',
                    'target_group_id' => $dependency->target_group_id ? (int) $dependency->target_group_id : null,
                    'target_option_id' => $dependency->target_option_id ? (int) $dependency->target_option_id : null,
                ];
            })
            ->values();

        $priceRules = $product->priceRules
            ->map(function ($rule) use ($langKey, $useTaxIncludedPrice) {
                return [
                    'rule_id' => (int) $rule->rule_id,
                    'rule_name' => $rule->rule_name,
                    'option_ids' => $rule->options
                        ->filter(function ($option) use ($langKey) {
                            return $option->language === $langKey;
                        })
                        ->pluck('option_id')
                        ->map(fn ($id) => (int) $id)
                        ->values(),
                    'tiers' => $rule->tiers
                        ->map(function ($tier) use ($useTaxIncludedPrice) {
                            return [
                                'min_qty' => (int) $tier->min_qty,
                                'max_qty' => $tier->max_qty ? (int) $tier->max_qty : null,
                                'unit_price' => $useTaxIncludedPrice
                                    ? (float) ($tier->unit_price_with_tax ?? $tier->unit_price ?? 0)
                                    : (float) ($tier->unit_price ?? 0),
                            ];
                        })
                        ->values(),
                ];
            })
            ->values();

        return view('products.hotmobily_show', compact(
            'product',
            'optionGroups',
            'dependencies',
            'priceRules',
            'priceTaxMode',
            'useTaxIncludedPrice'
        ));
    }

    public function showHotmobily(Product $product)
    {
        $langKey = $this->getLangKey();

        $priceTaxMode = Cache::remember('system_setting_price_tax_mode', 3600, function () {
            return SystemSetting::getValue('price_tax_mode', 'exclude_tax');
        });

        $useTaxIncludedPrice = $priceTaxMode === 'include_tax';

        /*
|--------------------------------------------------------------------------
| Check product type first
|--------------------------------------------------------------------------
*/
        if ((int) $product->product_type !== 2) {
            abort(404);
        }

        /*
|--------------------------------------------------------------------------
| Redirect to translated product if current language is different
|--------------------------------------------------------------------------
| ถ้าเปลี่ยนภาษาแล้วสินค้ามีตัวแปล ให้พาไปตัวแปล
| ถ้าไม่มี ให้ set locale กลับเป็นภาษาของสินค้าปัจจุบัน แล้ว redirect กลับหน้าเดิม
|--------------------------------------------------------------------------
*/
        if ($product->language !== $langKey) {
            if (! empty($product->translation_key)) {
                $translatedProduct = Product::where('translation_key', $product->translation_key)
                    ->where('language', $langKey)
                    ->where('is_active', 1)
                    ->where('product_type', 2)
                    ->first();

                if ($translatedProduct) {
                    return redirect()->route('products.hotmobily.show', $translatedProduct->product_id);
                }
            }

            session(['locale' => $product->language]);
            app()->setLocale($product->language);

            return redirect()
                ->route('products.hotmobily.show', $product->product_id)
                ->with('translation_unavailable', 'สินค้าตัวนี้ยังไม่พร้อมสำหรับภาษาที่เลือก');
        }
        $product->load([
            'mainImage',
            'images',
            'galleryImages',
            'detail',
            'category',
            'material',

            'priceRules.options',
            'priceRules.tiers',

            'assignedOptions.group.parent',
            'assignedOptions.mainImage',
            'assignedOptions.variants',
        ]);

        $groupOrders = ProductOptionGroupOrder::where('product_id', $product->product_id)
            ->pluck('sort_order', 'option_group_id');

        $optionGroups = $product->assignedOptions
            ->where('pivot.is_active', 1)
            ->filter(function ($option) use ($langKey) {
                return $option->language === $langKey
                    && $option->group
                    && $option->group->language === $langKey;
            })
            ->sortBy(function ($option) use ($groupOrders) {
                $group = $option->group;
                $parent = $group?->parent;

                $displayGroup = $parent ?: $group;
                $displayGroupId = $displayGroup?->option_group_id;

                return [
                    $groupOrders[$displayGroupId] ?? 999,
                    $parent->sort_order ?? $group->sort_order ?? 999,
                    $group->sort_order ?? 999,
                    $option->pivot->sort_order ?? 0,
                ];
            })
            ->groupBy(function ($option) {
                $group = $option->group;
                $displayGroup = $group?->parent ?: $group;

                return $displayGroup?->option_group_id ?? 0;
            });

        $dependencies = OptionDependency::where('is_active', 1)
            ->whereHas('parentOption', function ($query) use ($langKey) {
                $query->where('language', $langKey);
            })
            ->orderBy('sort_order')
            ->get()
            ->map(function ($dependency) {
                return [
                    'parent_option_id' => (int) $dependency->parent_option_id,
                    'target_type' => $dependency->target_type,
                    'action_type' => $dependency->action_type ?? 'show',
                    'target_group_id' => $dependency->target_group_id ? (int) $dependency->target_group_id : null,
                    'target_option_id' => $dependency->target_option_id ? (int) $dependency->target_option_id : null,
                ];
            })
            ->values();

        $priceRules = $product->priceRules
            ->map(function ($rule) use ($langKey, $useTaxIncludedPrice) {
                return [
                    'rule_id' => (int) $rule->rule_id,
                    'rule_name' => $rule->rule_name,
                    'option_ids' => $rule->options
                        ->filter(function ($option) use ($langKey) {
                            return $option->language === $langKey;
                        })
                        ->pluck('option_id')
                        ->map(fn ($id) => (int) $id)
                        ->values(),
                    'tiers' => $rule->tiers
                        ->map(function ($tier) use ($useTaxIncludedPrice) {
                            return [
                                'min_qty' => (int) $tier->min_qty,
                                'max_qty' => $tier->max_qty ? (int) $tier->max_qty : null,
                                'unit_price' => $useTaxIncludedPrice
                                    ? (float) ($tier->unit_price_with_tax ?? $tier->unit_price ?? 0)
                                    : (float) ($tier->unit_price ?? 0),
                            ];
                        })
                        ->values(),
                ];
            })
            ->values();

        return view('products.hotmobily_show', compact(
            'product',
            'optionGroups',
            'dependencies',
            'priceRules',
            'priceTaxMode',
            'useTaxIncludedPrice'
        ));
    }

    public function description($code)
    {
        $langKey = $this->getLangKey();

        /*
    |--------------------------------------------------------------------------
    | 1. Try to find product by current language and product_code
    |--------------------------------------------------------------------------
    */
        $product = Product::with([
            'mainImage',
            'images',
            'galleryImages',
            'detail',
            'category',
            'material',
        ])
            ->where('language', $langKey)
            ->where('product_code', $code)
            ->where('is_active', 1)
            ->first();

        /*
    |--------------------------------------------------------------------------
    | 2. If not found, try to find translated product by translation_key
    |--------------------------------------------------------------------------
    */
        if (! $product) {
            $currentProduct = Product::where('product_code', $code)->first();

            if ($currentProduct && $currentProduct->translation_key) {
                $translatedProduct = Product::where('translation_key', $currentProduct->translation_key)
                    ->where('language', $langKey)
                    ->where('is_active', 1)
                    ->first();

                if ($translatedProduct) {
                    return redirect()->route('products.description', $translatedProduct->product_code);
                }
            }

            /*
        |--------------------------------------------------------------------------
        | 3. Translation unavailable
        |--------------------------------------------------------------------------
        | กลับไปภาษาของสินค้าตัวเดิม และอยู่หน้าเดิม
        |--------------------------------------------------------------------------
        */
            if ($currentProduct && $currentProduct->language) {
                session(['locale' => $currentProduct->language]);
                app()->setLocale($currentProduct->language);

                return redirect()
                    ->route('products.description', $currentProduct->product_code)
                    ->with('translation_unavailable', 'This product is not available in the selected language yet.');
            }

            abort(404);
        }

        $relatedProducts = Product::with('mainImage')
            ->where('language', $langKey)
            ->where('is_active', 1)
            ->where('category_id', $product->category_id)
            ->where('product_id', '!=', $product->product_id)
            ->where('product_type', $product->product_type)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $views = 'products.hotstrap_desc';

        if ((int) $product->product_type === PRODUCT_HOTMOBILY) {
            $views = 'products.hotmobily_desc';
        }

        $productFaqs = Faq::where('language', $langKey)
            ->where('status', 'show')
            ->where('show_product', 1)
            ->where(function ($query) use ($product) {
                $query->whereNull('product_id')
                    ->orWhere('product_id', $product->product_id);
            })
            ->orderBy('sort_order')
            ->orderBy('faq_id', 'desc')
            ->limit(5)
            ->get();

        return view($views, compact('product', 'relatedProducts', 'productFaqs'));
    }

    public function order($code)
    {
        $langKey = $this->getLangKey();

        $priceTaxMode = Cache::remember('system_setting_price_tax_mode', 3600, function () {
            return SystemSetting::getValue('price_tax_mode', 'exclude_tax');
        });

        $useTaxIncludedPrice = $priceTaxMode === 'include_tax';

        /*
    |--------------------------------------------------------------------------
    | 1. Find product by current language and product_code
    |--------------------------------------------------------------------------
    */
        $product = Product::with([
            'mainImage',
            'images',
            'galleryImages',
            'detail',
            'category',
            'material',
            'priceRules.options',
            'priceRules.tiers',
            'assignedOptions.group.parent',
            'assignedOptions.mainImage',
            'assignedOptions.variants',
        ])
            ->where('language', $langKey)
            ->where('product_code', $code)
            ->where('is_active', 1)
            ->first();

        /*
    |--------------------------------------------------------------------------
    | 2. If not found, try redirect by translation_key
    |--------------------------------------------------------------------------
    */
        if (! $product) {
            $currentProduct = Product::where('product_code', $code)->first();

            if ($currentProduct) {
                if (! empty($currentProduct->translation_key)) {
                    $translatedProduct = Product::where('translation_key', $currentProduct->translation_key)
                        ->where('language', $langKey)
                        ->where('is_active', 1)
                        ->first();

                    if ($translatedProduct) {
                        return redirect()->route('products.order', [
                            'code' => $translatedProduct->product_code,
                        ]);
                    }
                }

                session(['locale' => $currentProduct->language]);
                app()->setLocale($currentProduct->language);

                return redirect()
                    ->route('products.order', ['code' => $currentProduct->product_code])
                    ->with('translation_unavailable', 'สินค้าตัวนี้ยังไม่พร้อมสำหรับภาษาที่เลือก');
            }

            abort(404);
        }

        $groupOrders = ProductOptionGroupOrder::where('product_id', $product->product_id)
            ->pluck('sort_order', 'option_group_id');

        $optionGroups = $product->assignedOptions
            ->where('pivot.is_active', 1)
            ->filter(function ($option) use ($langKey) {
                return $option->language === $langKey
                    && $option->group
                    && $option->group->language === $langKey;
            })
            ->sortBy(function ($option) use ($groupOrders) {
                $group = $option->group;
                $parent = $group?->parent;

                $displayGroup = $parent ?: $group;
                $displayGroupId = $displayGroup?->option_group_id;

                return [
                    $groupOrders[$displayGroupId] ?? 999,
                    $parent->sort_order ?? $group->sort_order ?? 999,
                    $group->sort_order ?? 999,
                    $option->pivot->sort_order ?? 0,
                ];
            })
            ->groupBy(function ($option) {
                $group = $option->group;
                $displayGroup = $group?->parent ?: $group;

                return $displayGroup?->option_group_id ?? 0;
            });

        $dependencies = OptionDependency::where('is_active', 1)
            ->whereHas('parentOption', function ($query) use ($langKey) {
                $query->where('language', $langKey);
            })
            ->orderBy('sort_order')
            ->get()
            ->map(function ($dependency) {
                return [
                    'parent_option_id' => (int) $dependency->parent_option_id,
                    'target_type' => $dependency->target_type,
                    'action_type' => $dependency->action_type ?? 'show',
                    'target_group_id' => $dependency->target_group_id ? (int) $dependency->target_group_id : null,
                    'target_option_id' => $dependency->target_option_id ? (int) $dependency->target_option_id : null,
                ];
            })
            ->values();

        $priceRules = $product->priceRules
            ->map(function ($rule) use ($langKey, $useTaxIncludedPrice) {
                return [
                    'rule_id' => (int) $rule->rule_id,
                    'rule_name' => $rule->rule_name,
                    'option_ids' => $rule->options
                        ->filter(function ($option) use ($langKey) {
                            return $option->language === $langKey;
                        })
                        ->pluck('option_id')
                        ->map(fn ($id) => (int) $id)
                        ->values(),
                    'tiers' => $rule->tiers
                        ->map(function ($tier) use ($useTaxIncludedPrice) {
                            return [
                                'min_qty' => (int) $tier->min_qty,
                                'max_qty' => $tier->max_qty ? (int) $tier->max_qty : null,
                                'unit_price' => $useTaxIncludedPrice
                                    ? (float) ($tier->unit_price_with_tax ?? $tier->unit_price ?? 0)
                                    : (float) ($tier->unit_price ?? 0),
                            ];
                        })
                        ->values(),
                ];
            })
            ->values();

        $views = 'products.hotstrap_show';

        if ((int) $product->product_type === PRODUCT_HOTMOBILY) {
            $views = 'products.hotmobily_show';
        }

        return view($views, compact(
            'product',
            'optionGroups',
            'dependencies',
            'priceRules',
            'priceTaxMode',
            'useTaxIncludedPrice'
        ));
    }
    public function previewOrder(Product $product)
{
    /*
    |--------------------------------------------------------------------------
    | Admin preview only: allow Public and Draft
    |--------------------------------------------------------------------------
    */
    if (!in_array((int) $product->is_active, [1, 3], true)) {
        abort(404);
    }

    $langKey = $product->language ?? $this->getLangKey();

    $priceTaxMode = Cache::remember('system_setting_price_tax_mode', 3600, function () {
        return SystemSetting::getValue('price_tax_mode', 'exclude_tax');
    });

    $useTaxIncludedPrice = $priceTaxMode === 'include_tax';

    $product->load([
        'mainImage',
        'images',
        'galleryImages',
        'detail',
        'category',
        'material',
        'priceRules.options',
        'priceRules.tiers',
        'assignedOptions.group.parent',
        'assignedOptions.mainImage',
        'assignedOptions.variants',
    ]);

    $groupOrders = ProductOptionGroupOrder::where('product_id', $product->product_id)
        ->pluck('sort_order', 'option_group_id');

    $optionGroups = $product->assignedOptions
        ->where('pivot.is_active', 1)
        ->filter(function ($option) use ($langKey) {
            return $option->language === $langKey
                && $option->group
                && $option->group->language === $langKey;
        })
        ->sortBy(function ($option) use ($groupOrders) {
            $group = $option->group;
            $parent = $group?->parent;

            $displayGroup = $parent ?: $group;
            $displayGroupId = $displayGroup?->option_group_id;

            return [
                $groupOrders[$displayGroupId] ?? 999,
                $parent->sort_order ?? $group->sort_order ?? 999,
                $group->sort_order ?? 999,
                $option->pivot->sort_order ?? 0,
            ];
        })
        ->groupBy(function ($option) {
            $group = $option->group;
            $displayGroup = $group?->parent ?: $group;

            return $displayGroup?->option_group_id ?? 0;
        });

    $dependencies = OptionDependency::where('is_active', 1)
        ->whereHas('parentOption', function ($query) use ($langKey) {
            $query->where('language', $langKey);
        })
        ->orderBy('sort_order')
        ->get()
        ->map(function ($dependency) {
            return [
                'parent_option_id' => (int) $dependency->parent_option_id,
                'target_type' => $dependency->target_type,
                'action_type' => $dependency->action_type ?? 'show',
                'target_group_id' => $dependency->target_group_id ? (int) $dependency->target_group_id : null,
                'target_option_id' => $dependency->target_option_id ? (int) $dependency->target_option_id : null,
            ];
        })
        ->values();

    $priceRules = $product->priceRules
        ->map(function ($rule) use ($langKey, $useTaxIncludedPrice) {
            return [
                'rule_id' => (int) $rule->rule_id,
                'rule_name' => $rule->rule_name,
                'option_ids' => $rule->options
                    ->filter(function ($option) use ($langKey) {
                        return $option->language === $langKey;
                    })
                    ->pluck('option_id')
                    ->map(fn ($id) => (int) $id)
                    ->values(),
                'tiers' => $rule->tiers
                    ->map(function ($tier) use ($useTaxIncludedPrice) {
                        return [
                            'min_qty' => (int) $tier->min_qty,
                            'max_qty' => $tier->max_qty ? (int) $tier->max_qty : null,
                            'unit_price' => $useTaxIncludedPrice
                                ? (float) ($tier->unit_price_with_tax ?? $tier->unit_price ?? 0)
                                : (float) ($tier->unit_price ?? 0),
                        ];
                    })
                    ->values(),
            ];
        })
        ->values();

    $isAdminPreview = true;

    $views = 'products.hotstrap_show';

    if ((int) $product->product_type === PRODUCT_HOTMOBILY) {
        $views = 'products.hotmobily_show';
    }

    return view($views, compact(
        'product',
        'optionGroups',
        'dependencies',
        'priceRules',
        'priceTaxMode',
        'useTaxIncludedPrice',
        'isAdminPreview'
    ));
}
}
