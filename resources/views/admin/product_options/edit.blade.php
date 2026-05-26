@extends('admin.layouts.app')

@section('title', 'Edit Product Option | Indigo Admin')

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

        .color-picker-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .color-picker-group input[type="color"] {
            width: 52px;
            height: 42px;
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 16px;
        }

        .image-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .image-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            display: block;
        }

        .image-card-body {
            padding: 12px;
        }

        .image-main-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            padding: 4px 8px;
            border-radius: 999px;
            background: #ecfdf5;
            color: #047857;
            font-size: 11px;
            font-weight: 700;
        }

        .remove-check {
            color: #dc2626;
            font-size: 13px;
        }

        .remove-check input {
            margin-right: 4px;
        }

        @media (max-width: 900px) {

            .form-grid,
            .checkbox-grid {
                grid-template-columns: 1fr;
            }

            .form-header {
                flex-direction: column;
            }

            .image-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .remove-check,
        .main-image-check {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 13px;
            line-height: 1.2;
        }

        .remove-check {
            color: #dc2626;
        }

        .main-image-check {
            color: #047857;
            font-weight: 600;
        }

        .remove-check input,
        .main-image-check input {
            width: 14px;
            height: 14px;
            margin: 0;
        }
    </style>
@endsection

@section('content')

    <div class="form-card">
        <div class="form-header">
            <div>
                <h1>Edit Product Option</h1>
                <p>Update option details, price, color, images and variants.</p>
            </div>

            <a href="{{ route('admin.product-options.index') }}" class="btn-outline">
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

        <form action="{{ route('admin.product-options.update', $option->option_id) }}" method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="section-title">Option Information</div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Option Group</label>

                    <select name="option_group_id">
                        <option value="">-- Select Group --</option>

                        @foreach ($groups as $group)
                            <option value="{{ $group->option_group_id }}"
                                {{ old('option_group_id', $option->option_group_id) == $group->option_group_id ? 'selected' : '' }}>
                                {{ $group->group_name }} ({{ $group->group_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Option Code</label>

                    <input type="text" name="option_code" value="{{ old('option_code', $option->option_code) }}">
                </div>

                <div class="form-group">
                    <label>Option Name</label>

                    <input type="text" name="option_name" value="{{ old('option_name', $option->option_name) }}">
                </div>

                <div class="form-group">
                    <label>Additional Price</label>

                    <input type="number" step="0.01" name="additional_price"
                        value="{{ old('additional_price', $option->additional_price) }}">
                </div>

                <div class="form-group">
                    <label>Price Type</label>

                    <select name="price_type">
                        <option value="per_item"
                            {{ old('price_type', $option->price_type) == 'per_item' ? 'selected' : '' }}>
                            per_item - คิดต่อชิ้น
                        </option>

                        <option value="per_order"
                            {{ old('price_type', $option->price_type) == 'per_order' ? 'selected' : '' }}>
                            per_order - คิดต่อออเดอร์
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Color Code</label>

                    <div class="color-picker-group">
                        <input type="text" name="color_code" id="color_code_input"
                            value="{{ old('color_code', $option->color_code) }}" placeholder="เช่น #ff0000">

                        <input type="color" value="{{ old('color_code', $option->color_code ?: '#000000') }}"
                            onchange="document.getElementById('color_code_input').value = this.value">
                    </div>
                </div>

                <div class="form-group full">
                    <label>Option Detail</label>

                    <textarea name="option_detail" rows="8"
                        placeholder="เช่น&#10;Model: ID-6_N&#10;Type: Soft Card Holder&#10;Card Size: 91 mm (H) x 55 mm (W)">{{ old('option_detail', $option->option_detail) }}</textarea>
                </div>
            </div>

            <div class="section-title">Option Status</div>

            <div class="checkbox-grid">
                <label>
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $option->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="section-title">Current Images</div>

            @if ($option->images && $option->images->count())
                <div class="image-grid">
                    @foreach ($option->images as $image)
                        <div class="image-card">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Option Image">

                            <div class="image-card-body">
                                @if ($image->is_main)
                                    <label class="main-image-check">
                                        <span>Main Image</span>
                                        <input type="checkbox" checked disabled>
                                    </label>
                                @endif

                                <label class="remove-check">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->image_id }}">
                                    <span>Remove image</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No images</p>
            @endif

            <div class="section-title">Add New Images</div>

            <div class="form-group">
                <label>Add New Option Images</label>
                <input type="file" name="images[]" multiple accept="image/*">
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.product-options.index') }}" class="btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn-primary">
                    Update Product Option
                </button>
            </div>
        </form>
    </div>

@endsection
