@extends('admin.layouts.app')

@section('title', 'Edit Gallery | Indigo Admin')

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

    .form-header p,
    .muted-text {
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

    .form-group label,
    .image-panel > label {
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

    .section-title {
        margin: 28px 0 16px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
        font-size: 18px;
        font-weight: 700;
        color: var(--fg-dark);
    }

    .image-panel {
        margin-bottom: 18px;
    }

    .image-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .image-box {
        width: 130px;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px;
        background: var(--bg);
    }

    .image-box img {
        width: 100%;
        height: 90px;
        object-fit: cover;
        display: block;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 8px;
    }

    .delete-image-label {
        margin-top: 6px;
        font-size: 12px;
        color: #dc2626;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
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

    .alert-error,
    .alert-success {
        margin-bottom: 18px;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
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
            <h1>Edit Gallery</h1>
            <p>Update gallery information, cover image and gallery images.</p>
        </div>

        <a href="{{ route('admin.galleries.index') }}" class="btn-outline">
            Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.galleries.update', $gallery->gallery_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group full">
                <label>Gallery Title</label>
                <input type="text" name="title" value="{{ old('title', $gallery->title) }}">
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ old('category_id', $gallery->category_id) == $category->category_id ? 'selected' : '' }}>
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
                        <option value="{{ $material->material_id }}"
                            {{ old('material_id', $gallery->material_id) == $material->material_id ? 'selected' : '' }}>
                            {{ $material->material_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group full">
                <label>Purpose</label>
                <textarea name="purpose" rows="4">{{ old('purpose', $gallery->purpose) }}</textarea>
            </div>
            <div class="form-group full">
    <label>Product Link</label>
    <input
        type="text"
        name="product_link"
        value="{{ old('product_link', $gallery->product_link) }}"
        placeholder="https://example.com/products/..."
    >
</div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="gallery_date"
                    value="{{ old('gallery_date', $gallery->gallery_date ? $gallery->gallery_date->format('Y-m-d') : '') }}">
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}">
            </div>
        </div>

        <div class="section-title">Cover Image</div>

        <div class="image-panel">
            <label>Current Cover Image</label>

            @if($gallery->cover_image)
                <div class="image-grid">
                    <div class="image-box">
                        <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}">

                        <label class="delete-image-label">
                            <input type="checkbox" name="remove_cover_image" value="1">
                            Remove Cover
                        </label>
                    </div>
                </div>
            @else
                <p class="muted-text">No cover image</p>
            @endif
        </div>

        <div class="form-group">
            <label>Change Cover Image</label>
            <input type="file" name="cover_image" accept="image/*">
        </div>

        <div class="section-title">Gallery Images</div>

        <div class="image-panel">
            <label>Current Gallery Images</label>

            <div class="image-grid">
                @forelse($gallery->images as $image)
                    <div class="image-box">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery image">

                        <label class="delete-image-label">
                            <input
                                type="checkbox"
                                name="delete_gallery_images[]"
                                value="{{ $image->gallery_image_id }}"
                            >
                            Delete
                        </label>
                    </div>
                @empty
                    <p class="muted-text">No gallery images</p>
                @endforelse
            </div>
        </div>

        <div class="form-group">
            <label>Add Gallery Images</label>
            <input type="file" name="gallery_images[]" multiple accept="image/*">
        </div>

        <div class="section-title">Status</div>

        <div class="checkbox-grid">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                Active
            </label>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.galleries.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">Update Gallery</button>
        </div>
    </form>
</div>

@endsection