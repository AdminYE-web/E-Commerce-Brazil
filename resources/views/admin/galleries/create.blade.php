@extends('admin.layouts.app')

@section('title', 'Add Gallery | Indigo Admin')

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

        .form-group input,
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

        .checkbox-grid label {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            color: var(--fg);
            display: inline-flex;
            gap: 8px;
            align-items: center;
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

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-primary {
            background: var(--accent);
            border: 1px solid var(--accent);
            color: #fff;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')

    <div class="form-card">
        <div class="form-header">
            <div>
                <h1>Add Gallery</h1>
                <p>Create gallery with cover image and multiple gallery images.</p>
            </div>

            <a href="{{ route('admin.galleries.index') }}" class="btn-outline">
                Back
            </a>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group full">
                    <label>Gallery Title</label>
                    <input type="text" name="title" value="{{ old('title') }}">
                </div>
                <div class="form-group" style="display: none">
                    <label>Translation Key</label>
                    <input type="text" name="translation_key" value="{{ old('translation_key', $translationKey ?? '') }}"
                        placeholder="เช่น gal_xxxxxxxx">
                    <small>ใช้สำหรับผูก Gallery เดียวกันข้ามภาษา</small>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Material</label>
                    <select name="material_id">
                        <option value="">-- Select Material --</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->material_id }}" {{ old('material_id') == $material->material_id ? 'selected' : '' }}>
                                {{ $material->material_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group full">
                    <label>Purpose</label>
                    <textarea name="purpose" rows="4">{{ old('purpose') }}</textarea>
                </div>
                <div class="form-group full">
                    <label>Product Link</label>
                    <input type="text" name="product_link" value="{{ old('product_link') }}"
                        placeholder="https://example.com/products/...">
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="gallery_date" value="{{ old('gallery_date') }}">
                </div>

                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
                </div>

                <div class="form-group">
                    <label>Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Gallery Images</label>
                    <input type="file" name="gallery_images[]" multiple accept="image/*">
                </div>

                <div class="form-group full checkbox-grid">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        Active
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.galleries.index') }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Save Gallery</button>
            </div>
        </form>
    </div>

@endsection