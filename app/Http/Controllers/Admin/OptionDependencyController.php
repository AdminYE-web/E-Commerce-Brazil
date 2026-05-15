<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionDependency;
use App\Models\OptionGroup;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class OptionDependencyController extends Controller
{
    public function index()
{
    $language = session('admin_product_language', 'pt');

    $dependencies = OptionDependency::with([
            'parentOption.group',
            'targetGroup',
            'targetOption.group',
        ])
        ->whereHas('parentOption', function ($query) use ($language) {
            $query->where('language', $language);
        })
        ->orderBy('dependency_id', 'desc')
        ->paginate(20);

    return view('admin.option_dependencies.index', compact('dependencies', 'language'));
}

    public function create()
{
    $language = session('admin_product_language', 'pt');

    $options = ProductOption::with('group')
        ->where('language', $language)
        ->where('is_active', 1)
        ->whereHas('group', function ($query) use ($language) {
            $query->where('language', $language);
        })
        ->orderBy('option_group_id')
        ->orderBy('option_name')
        ->get();

    $groups = OptionGroup::where('language', $language)
        ->where('is_active', 1)
        ->orderBy('sort_order')
        ->orderBy('group_name')
        ->get();

    return view('admin.option_dependencies.create', compact('options', 'groups', 'language'));
}

    public function store(Request $request)
    {
        $request->validate([
            'parent_option_id' => 'required|exists:product_options,option_id',
            'target_type' => 'required|in:group,option',
            'target_group_id' => 'nullable|required_if:target_type,group|exists:option_groups,option_group_id',
            'target_option_id' => 'nullable|required_if:target_type,option|exists:product_options,option_id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        OptionDependency::create([
            'parent_option_id' => $request->parent_option_id,

            // เก็บ child_option_id ไว้ด้วย เพื่อรองรับโครงเดิม
            'child_option_id' => $request->target_type === 'option'
                ? $request->target_option_id
                : null,

            'target_type' => $request->target_type,
            'target_group_id' => $request->target_type === 'group'
                ? $request->target_group_id
                : null,
            'target_option_id' => $request->target_type === 'option'
                ? $request->target_option_id
                : null,

            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('success', 'Option dependency created successfully.');
    }

   public function edit(OptionDependency $optionDependency)
{
    $optionDependency->load([
        'parentOption',
        'targetOption',
        'targetGroup',
    ]);

    $language = $optionDependency->parentOption->language
        ?? session('admin_product_language', 'pt');

    $options = ProductOption::with('group')
        ->where('language', $language)
        ->where('is_active', 1)
        ->whereHas('group', function ($query) use ($language) {
            $query->where('language', $language);
        })
        ->orderBy('option_group_id')
        ->orderBy('option_name')
        ->get();

    $groups = OptionGroup::where('language', $language)
        ->where('is_active', 1)
        ->orderBy('sort_order')
        ->orderBy('group_name')
        ->get();

    return view('admin.option_dependencies.edit', [
        'dependency' => $optionDependency,
        'options' => $options,
        'groups' => $groups,
        'language' => $language,
    ]);
}

    public function update(Request $request, OptionDependency $optionDependency)
    {
        $request->validate([
            'parent_option_id' => 'required|exists:product_options,option_id',
            'target_type' => 'required|in:group,option',
            'target_group_id' => 'nullable|required_if:target_type,group|exists:option_groups,option_group_id',
            'target_option_id' => 'nullable|required_if:target_type,option|exists:product_options,option_id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $optionDependency->update([
            'parent_option_id' => $request->parent_option_id,

            'child_option_id' => $request->target_type === 'option'
                ? $request->target_option_id
                : null,

            'target_type' => $request->target_type,
            'target_group_id' => $request->target_type === 'group'
                ? $request->target_group_id
                : null,
            'target_option_id' => $request->target_type === 'option'
                ? $request->target_option_id
                : null,

            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('success', 'Option dependency updated successfully.');
    }

    public function destroy(OptionDependency $optionDependency)
    {
        $optionDependency->delete();

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('success', 'Option dependency deleted successfully.');
    }
}