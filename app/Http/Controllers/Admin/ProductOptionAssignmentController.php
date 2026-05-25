<?php

namespace App\Http\Controllers\Admin;


use App\Models\ProductOptionGroupOrder;
use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductOptionAssignmentController extends Controller
{
    public function edit(Product $product)
    {
        $product->load('assignedOptions');

        $language = $product->language ?? session('admin_product_language', 'pt');

        $groups = OptionGroup::with(['options' => function ($query) use ($language) {
            $query->where('language', $language)
                ->where('is_active', 1)
                ->orderBy('option_name');
        }])
            ->where('language', $language)
            ->where('is_active', 1)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | ดึงลำดับ group เฉพาะ product นี้
    |--------------------------------------------------------------------------
    */
        $groupOrders = ProductOptionGroupOrder::where('product_id', $product->product_id)
            ->pluck('sort_order', 'option_group_id');

        /*
    |--------------------------------------------------------------------------
    | เรียง group ตามลำดับเฉพาะ product นี้
    | ถ้า product นี้ยังไม่เคยจัดลำดับ ให้ fallback ไปใช้ sort_order กลาง / group_name
    |--------------------------------------------------------------------------
    */
        $groups = $groups->sortBy(function ($group) use ($groupOrders) {
            return [
                $groupOrders[$group->option_group_id] ?? 999,
                $group->sort_order ?? 999,
                $group->group_name,
            ];
        })->values();

        $assignedOptionIds = $product->assignedOptions
            ->pluck('option_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        $assignedPivot = $product->assignedOptions
            ->keyBy('option_id');

        return view('admin.product_option_assignments.edit', compact(
            'product',
            'groups',
            'language',
            'assignedOptionIds',
            'assignedPivot'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'options' => 'nullable|array',
            'options.*.option_id' => 'required|exists:product_options,option_id',
            'options.*.sort_order' => 'nullable|integer|min:0',
            'options.*.is_default' => 'nullable|boolean',
            'options.*.is_active' => 'nullable|boolean',
        ]);

        $syncData = [];

        foreach ($request->input('options', []) as $item) {
            $optionId = (int) $item['option_id'];

            $syncData[$optionId] = [
                'sort_order' => $item['sort_order'] ?? 0,
                'is_default' => !empty($item['is_default']) ? 1 : 0,
                'is_active' => !empty($item['is_active']) ? 1 : 0,
            ];
        }

        $product->assignedOptions()->sync($syncData);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product options updated successfully.');
    }
    public function updateGroupSort(Request $request, Product $product)
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.option_group_id' => ['required', 'exists:option_groups,option_group_id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->items as $item) {
            ProductOptionGroupOrder::updateOrCreate(
                [
                    'product_id' => $product->product_id,
                    'option_group_id' => $item['option_group_id'],
                ],
                [
                    'sort_order' => $item['sort_order'],
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Product option group order updated successfully.',
        ]);
    }
}
