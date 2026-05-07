<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductOptionAssignmentController extends Controller
{
    public function edit(Product $product)
    {
        $product->load('assignedOptions');

        $groups = OptionGroup::with([
                'options' => function ($query) {
                    $query->where('is_active', 1)
                        ->orderBy('option_name');
                }
            ])
            ->orderBy('group_name')
            ->get();

        $assignedOptionIds = $product->assignedOptions
            ->pluck('option_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $assignedPivot = $product->assignedOptions
            ->keyBy('option_id');

        return view('admin.product_option_assignments.edit', compact(
            'product',
            'groups',
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
}