<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use Illuminate\Http\Request;

class OptionGroupController extends Controller
{
    public function index()
{
    $groups = OptionGroup::with('parent')
        ->orderBy('sort_order')
        ->orderBy('option_group_id', 'desc')
        ->paginate(10);

    return view('admin.option_groups.index', compact('groups'));
}

   public function create()
{
    $parentGroups = OptionGroup::whereNull('parent_group_id')
        ->where('is_active', 1)
        ->orderBy('sort_order')
        ->orderBy('group_name')
        ->get();

    return view('admin.option_groups.create', compact('parentGroups'));
}

    public function store(Request $request)
    {
        $request->validate([
            'group_code' => 'required|string|max:100|unique:option_groups,group_code',
            'group_name' => 'required|string|max:255',
            'display_type' => 'required|string|in:button,image_card,color,select_detail,image_card_variant,image_grid_compact,grouped_buttons',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'help_text' => 'nullable|string',
            'parent_group_id' => 'nullable|exists:option_groups,option_group_id',
            'option_group_main' => 'nullable|boolean',
        ]);

        OptionGroup::create([
            'parent_group_id' => $request->parent_group_id,
            'group_code' => $request->group_code,
            'group_name' => $request->group_name,
             'help_text' => $request->help_text,
            'is_required' => $request->has('is_required') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'display_type' => $request->display_type,
            'sort_order' => $request->sort_order ?? 0,
            'option_group_main' => $request->has('option_group_main') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.option-groups.index')
            ->with('success', 'เพิ่มกลุ่มตัวเลือกเรียบร้อยแล้ว');
    }

  public function edit(OptionGroup $optionGroup)
{
    $parentGroups = OptionGroup::whereNull('parent_group_id')
        ->where('option_group_id', '!=', $optionGroup->option_group_id)
        ->where('is_active', 1)
        ->orderBy('sort_order')
        ->orderBy('group_name')
        ->get();

    return view('admin.option_groups.edit', compact('optionGroup', 'parentGroups'));
}

    public function update(Request $request, OptionGroup $optionGroup)
    {
        $request->validate([
            'group_code' => 'required|string|max:100|unique:option_groups,group_code,'.$optionGroup->option_group_id.',option_group_id',
            'group_name' => 'required|string|max:255',
            'display_type' => 'required|string|in:button,image_card,color,select_detail,image_card_variant,image_grid_compact,grouped_buttons',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'help_text' => 'nullable|string',
            'parent_group_id' => 'nullable|exists:option_groups,option_group_id',
            'option_group_main' => 'nullable|boolean',
        ]);

        $optionGroup->update([
            'parent_group_id' => $request->parent_group_id,
            'group_code' => $request->group_code,
            'group_name' => $request->group_name,
            'display_type' => $request->display_type,
            'is_required' => $request->has('is_required') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'help_text' => $request->help_text,
            'option_group_main' => $request->has('option_group_main') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.option-groups.index')
            ->with('success', 'แก้ไขกลุ่มตัวเลือกเรียบร้อยแล้ว');
    }

    public function destroy(OptionGroup $optionGroup)
    {
        $optionGroup->delete();

        return redirect()
            ->route('admin.option-groups.index')
            ->with('success', 'ลบกลุ่มตัวเลือกเรียบร้อยแล้ว');
    }
}
