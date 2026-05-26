@extends('admin.layouts.app')

@section('title', 'Edit Option Dependency | Indigo Admin')

@section('css')
    <style>
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-header h1 {
            margin: 0 0 6px;
            font-size: 24px;
            color: var(--fg-dark);
        }

        .form-header p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--fg-dark);
        }

        .form-group input[type="number"],
        .form-group select {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            font-family: inherit;
            background: #fff;
            color: var(--fg);
        }

        .section-title {
            margin: 28px 0 16px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 18px;
            font-weight: 700;
            color: var(--fg-dark);
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .checkbox-grid label {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            color: var(--fg);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn-outline,
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            font-family: inherit;
            line-height: 1;
        }

        .btn-outline {
            background: #fff;
            border: 1px solid var(--border);
            color: var(--fg);
        }

        .btn-primary {
            background: var(--accent);
            border: 1px solid var(--accent);
            color: #fff;
        }

        .alert-error {
            margin-bottom: 18px;
            padding: 12px 16px;
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 900px) {

            .form-grid,
            .checkbox-grid {
                grid-template-columns: 1fr;
            }

            .form-header {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')

    <div class="form-card">
        <div class="form-header">
            <div>
                <h1>Edit Option Dependency</h1>
                <p>Update conditional display rule between options and groups.</p>
            </div>

            <a href="{{ route('admin.option-dependencies.index') }}" class="btn-outline">
                Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.option-dependencies.update', $dependency->dependency_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-title">Dependency Setting</div>

            <div class="form-grid">
                <div class="form-group full">
                    <label>Trigger Option</label>
                    <select name="parent_option_id" required>
                        <option value="">-- Select Trigger Option --</option>
                        <optgroup label="Hotstrap (Type 1)">
                            @foreach ($options->filter(fn($o) => optional($o->group)->product_type == 1) as $option)
                                <option value="{{ $option->option_id }}"
                                    {{ old('parent_option_id', $dependency->parent_option_id) == $option->option_id ? 'selected' : '' }}>
                                    {{ $option->group->group_name ?? '-' }} ({{ $option->group->group_code ?? '-' }}) / {{ $option->option_name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Hotmobily (Type 2)">
                            @foreach ($options->filter(fn($o) => optional($o->group)->product_type == 2) as $option)
                                <option value="{{ $option->option_id }}"
                                    {{ old('parent_option_id', $dependency->parent_option_id) == $option->option_id ? 'selected' : '' }}>
                                    {{ $option->group->group_name ?? '-' }} ({{ $option->group->group_code ?? '-' }}) / {{ $option->option_name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label>Target Type</label>
                    <select name="target_type" id="target_type" required>
                        <option value="option"
                            {{ old('target_type', $dependency->target_type) == 'option' ? 'selected' : '' }}>
                            option - แสดงเฉพาะ option
                        </option>

                        <option value="group"
                            {{ old('target_type', $dependency->target_type) == 'group' ? 'selected' : '' }}>
                            group - แสดงทั้ง group
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $dependency->sort_order) }}">
                </div>

                <div class="form-group full" id="target_option_box">
                    <label>Target Option</label>
                    <select name="target_option_id">
                        <option value="">-- Select Target Option --</option>
                        <optgroup label="Hotstrap (Type 1)">
                            @foreach ($options->filter(fn($o) => optional($o->group)->product_type == 1) as $option)
                                <option value="{{ $option->option_id }}"
                                    {{ old('target_option_id', $dependency->target_option_id) == $option->option_id ? 'selected' : '' }}>
                                    {{ $option->group->group_name ?? '-' }} ({{ $option->group->group_code ?? '-' }}) / {{ $option->option_name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Hotmobily (Type 2)">
                            @foreach ($options->filter(fn($o) => optional($o->group)->product_type == 2) as $option)
                                <option value="{{ $option->option_id }}"
                                    {{ old('target_option_id', $dependency->target_option_id) == $option->option_id ? 'selected' : '' }}>
                                    {{ $option->group->group_name ?? '-' }} ({{ $option->group->group_code ?? '-' }}) / {{ $option->option_name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                    <label>Action Type</label>
                    <select name="action_type" required>
                        <option value="show"
                            {{ old('action_type', $dependency->action_type ?? 'show') == 'show' ? 'selected' : '' }}>
                            show - แสดง target เมื่อเลือก Trigger Option
                        </option>

                        <option value="hide"
                            {{ old('action_type', $dependency->action_type ?? '') == 'hide' ? 'selected' : '' }}>
                            hide - ซ่อน target เมื่อเลือก Trigger Option
                        </option>

                        <option value="disable"
                            {{ old('action_type', $dependency->action_type ?? '') == 'disable' ? 'selected' : '' }}>
                            disable - ล็อก target ไม่ให้เลือก เมื่อเลือก Trigger Option
                        </option>
                    </select>
                </div>

                <div class="form-group full" id="target_group_box" style="display:none;">
                    <label>Target Group</label>
                    <select name="target_group_id">
                        <option value="">-- Select Target Group --</option>
                        <optgroup label="Hotstrap (Type 1)">
                            @foreach ($groups->where('product_type', 1) as $group)
                                <option value="{{ $group->option_group_id }}"
                                    {{ old('target_group_id', $dependency->target_group_id) == $group->option_group_id ? 'selected' : '' }}>
                                    {{ $group->group_name }} ({{ $group->group_code }})
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Hotmobily (Type 2)">
                            @foreach ($groups->where('product_type', 2) as $group)
                                <option value="{{ $group->option_group_id }}"
                                    {{ old('target_group_id', $dependency->target_group_id) == $group->option_group_id ? 'selected' : '' }}>
                                    {{ $group->group_name }} ({{ $group->group_code }})
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="section-title">Status</div>

            <div class="checkbox-grid">
                <label>
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $dependency->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.option-dependencies.index') }}" class="btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn-primary">
                    Update Dependency
                </button>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        function toggleTargetType() {
            const type = document.getElementById('target_type').value;
            const optionBox = document.getElementById('target_option_box');
            const groupBox = document.getElementById('target_group_box');

            if (type === 'group') {
                optionBox.style.display = 'none';
                groupBox.style.display = 'block';
            } else {
                optionBox.style.display = 'block';
                groupBox.style.display = 'none';
            }
        }

        document.getElementById('target_type').addEventListener('change', toggleTargetType);
        toggleTargetType();
    </script>
@endsection
