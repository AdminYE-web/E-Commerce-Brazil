<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionDependency;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class OptionDependencyController extends Controller
{
    public function index()
    {
        $dependencies = OptionDependency::with([
                'parentOption.group',
                'childOption.group',
            ])
            ->orderBy('dependency_id', 'desc')
            ->paginate(10);

        return view('admin.option_dependencies.index', compact('dependencies'));
    }

    public function create()
    {
        $options = ProductOption::with('group')
            ->where('is_active', 1)
            ->orderBy('option_group_id')
            ->orderBy('option_name')
            ->get();

        return view('admin.option_dependencies.create', compact('options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_option_id' => 'required|exists:product_options,option_id',
            'child_option_id' => 'required|exists:product_options,option_id|different:parent_option_id',
        ]);

        $exists = OptionDependency::where('parent_option_id', $request->parent_option_id)
            ->where('child_option_id', $request->child_option_id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'child_option_id' => 'Dependency นี้มีอยู่แล้ว',
                ])
                ->withInput();
        }

        OptionDependency::create([
            'parent_option_id' => $request->parent_option_id,
            'child_option_id' => $request->child_option_id,
        ]);

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('success', 'เพิ่ม Option Dependency เรียบร้อยแล้ว');
    }

    public function edit(OptionDependency $optionDependency)
    {
        $options = ProductOption::with('group')
            ->where('is_active', 1)
            ->orderBy('option_group_id')
            ->orderBy('option_name')
            ->get();

        return view('admin.option_dependencies.edit', [
            'dependency' => $optionDependency,
            'options' => $options,
        ]);
    }

    public function update(Request $request, OptionDependency $optionDependency)
    {
        $request->validate([
            'parent_option_id' => 'required|exists:product_options,option_id',
            'child_option_id' => 'required|exists:product_options,option_id|different:parent_option_id',
        ]);

        $exists = OptionDependency::where('parent_option_id', $request->parent_option_id)
            ->where('child_option_id', $request->child_option_id)
            ->where('dependency_id', '!=', $optionDependency->dependency_id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'child_option_id' => 'Dependency นี้มีอยู่แล้ว',
                ])
                ->withInput();
        }

        $optionDependency->update([
            'parent_option_id' => $request->parent_option_id,
            'child_option_id' => $request->child_option_id,
        ]);

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('success', 'แก้ไข Option Dependency เรียบร้อยแล้ว');
    }

    public function destroy(OptionDependency $optionDependency)
    {
        $optionDependency->delete();

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('success', 'ลบ Option Dependency เรียบร้อยแล้ว');
    }
}