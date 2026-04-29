<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use Illuminate\Http\Request;

class OptionGroupController extends Controller
{
    public function index()
    {
        $groups = OptionGroup::orderBy('option_group_id', 'desc')
            ->paginate(10);

        return view('admin.option_groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.option_groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_code' => 'required|string|max:100|unique:option_groups,group_code',
            'group_name' => 'required|string|max:255',
        ]);

        OptionGroup::create([
            'group_code' => $request->group_code,
            'group_name' => $request->group_name,
            'is_required' => $request->has('is_required') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.option-groups.index')
            ->with('success', 'เพิ่มกลุ่มตัวเลือกเรียบร้อยแล้ว');
    }

    public function edit(OptionGroup $optionGroup)
    {
        return view('admin.option_groups.edit', [
            'group' => $optionGroup,
        ]);
    }

    public function update(Request $request, OptionGroup $optionGroup)
    {
        $request->validate([
            'group_code' => 'required|string|max:100|unique:option_groups,group_code,' . $optionGroup->option_group_id . ',option_group_id',
            'group_name' => 'required|string|max:255',
        ]);

        $optionGroup->update([
            'group_code' => $request->group_code,
            'group_name' => $request->group_name,
            'is_required' => $request->has('is_required') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
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
