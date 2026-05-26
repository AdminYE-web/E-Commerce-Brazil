@extends('admin.layouts.app')

@section('title', 'Add Option Group | Indigo Admin')
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

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            font-family: inherit;
            background: #fff;
            color: var(--fg);
        }

        .form-group textarea {
            resize: vertical;
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
            grid-template-columns: repeat(3, 1fr);
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

        .checkbox-grid label small {
            display: block;
            margin-top: 6px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.4;
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

        .btn-outline:hover {
            background: var(--bg);
        }

        .btn-primary {
            background: var(--accent);
            border: 1px solid var(--accent);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
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
                <h1>Add Option Group</h1>
                <p>Create option group, display type, parent group and pricing condition.</p>
            </div>

            <a href="{{ route('admin.option-groups.index') }}" class="btn-outline">
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

        <form action="{{ route('admin.option-groups.store') }}" method="POST">
            @csrf

            <div class="section-title">Group Information</div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Product Type</label>
                    <select name="product_type" class="form-control" required>
                        <option value="1" {{ old('product_type', 1) == 1 ? 'selected' : '' }}>
                            Type 1 - Hotstrap
                        </option>
                        <option value="2" {{ old('product_type') == 2 ? 'selected' : '' }}>
                            Type 2 - Hotmobily
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Group Code</label>
                    <input type="text" name="group_code" value="{{ old('group_code') }}" placeholder="เช่น pouch_type">
                </div>

                <div class="form-group">
                    <label>Group Name</label>
                    <input type="text" name="group_name" value="{{ old('group_name') }}" placeholder="เช่น ประเภทซอง">
                </div>

                <div class="form-group">
                    <label>Parent Group</label>
                    <select name="parent_group_id">
                        <option value="">-- No Parent --</option>

                        @foreach ($parentGroups as $parent)
                            <option value="{{ $parent->option_group_id }}"
                                {{ old('parent_group_id') == $parent->option_group_id ? 'selected' : '' }}>
                                {{ $parent->group_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Display Type</label>
                    <select name="display_type">
                        <option value="button" {{ old('display_type', 'button') == 'button' ? 'selected' : '' }}>
                            button - ปุ่มข้อความ
                        </option>

                        <option value="image_card" {{ old('display_type') == 'image_card' ? 'selected' : '' }}>
                            image_card - การ์ดรูปภาพ
                        </option>

                        <option value="color" {{ old('display_type') == 'color' ? 'selected' : '' }}>
                            color - วงกลมสี
                        </option>

                        <option value="select_detail" {{ old('display_type') == 'select_detail' ? 'selected' : '' }}>
                            select_detail - Dropdown พร้อมรูปและรายละเอียด
                        </option>

                        <option value="image_card_variant"
                            {{ old('display_type') == 'image_card_variant' ? 'selected' : '' }}>
                            image_card_variant - การ์ดรูปภาพพร้อมเลือกสี
                        </option>

                        <option value="image_grid_compact"
                            {{ old('display_type') == 'image_grid_compact' ? 'selected' : '' }}>
                            image_grid_compact - การ์ดรูปภาพเล็กหลายคอลัมน์
                        </option>

                        <option value="grouped_buttons" {{ old('display_type') == 'grouped_buttons' ? 'selected' : '' }}>
                            grouped_buttons - หัวข้อหลักพร้อมคำถามย่อยหลายชุด
                        </option>

                        <option value="previous_order_design"
                            {{ old('display_type') == 'previous_order_design' ? 'selected' : '' }}>
                            previous_order_design - Yes/No + Previous Order No
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="form-group full">
                    <label>Help Text</label>
                    <textarea name="help_text" rows="4" placeholder="ข้อความที่จะแสดงเมื่อกดปุ่ม info">{{ old('help_text') }}</textarea>
                </div>
            </div>

            <div class="section-title">Group Status</div>

            <div class="checkbox-grid">
                <label>
                    <input type="checkbox" name="option_group_main" value="1"
                        {{ old('option_group_main') ? 'checked' : '' }}>
                    Main Price Group
                    <small>ใช้เป็นเงื่อนไขหลักใน Product Price Rules</small>
                </label>

                <label>
                    <input type="checkbox" name="is_required" value="1" {{ old('is_required', 1) ? 'checked' : '' }}>
                    Required
                </label>

                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.option-groups.index') }}" class="btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn-primary">
                    Save Option Group
                </button>
            </div>
        </form>
    </div>

@endsection
