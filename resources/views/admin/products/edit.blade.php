@extends('admin.layouts.app')

@section('title', 'Edit Product | Indigo Admin')

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

.form-group input[type="text"],
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

.form-group small {
    display: block;
    margin-top: 6px;
    color: var(--muted);
    font-size: 12px;
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
    width: 120px;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px;
    background: var(--bg);
}

.image-box img {
    width: 100%;
    height: 90px;
    object-fit: contain;
    display: block;
    border-radius: 8px;
    background: #fff;
    margin-bottom: 8px;
}

.radio-label {
    font-size: 12px;
    color: var(--fg);
    display: flex;
    gap: 6px;
    align-items: center;
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

.btn-primary:hover {
    background: var(--accent-hover);
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
.delete-image-label {
    margin-top: 6px;
    font-size: 12px;
    color: #dc2626;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}
</style>
@endsection
@section('content')

<div class="form-card">
    <div class="form-header">
        <div>
            <h1>Edit Product</h1>
            <p>Update product information, images, artwork settings and display status.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="btn-outline">
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

    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Product Code</label>
                <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}">
                <small>This section will be displayed as the product URL.</small>
            </div>
            <div class="form-group" style="display: none">
    <label>Translation Key</label>
    <input
        type="text"
        name="translation_key"
        value="{{ old('translation_key', $product->translation_key) }}"
        placeholder="เช่น polyester_lanyard_001"
    >
    <small>ใช้ key เดียวกันสำหรับสินค้าตัวเดียวกันในหลายภาษา</small>
</div>

            <div class="form-group">
                <label>Product Type</label>
                <select name="product_type">
                    <option value="1" {{ old('product_type', $product->product_type) == 1 ? 'selected' : '' }}>hotstrap</option>
                    <option value="2" {{ old('product_type', $product->product_type) == 2 ? 'selected' : '' }}>hotmobily</option>
                </select>
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Material</label>
                <select name="material_id">
                    <option value="">-- Select Material --</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->material_id }}"
                            {{ old('material_id', $product->material_id) == $material->material_id ? 'selected' : '' }}>
                            {{ $material->material_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group full">
                <label>Product Name</label>
                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}">
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="section-title">Product Images</div>

        <div class="image-panel">
            <label>Current Images</label>

            <div class="image-grid">
                @forelse ($product->images as $image)
                    <div class="image-box">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product image">

                        <label class="radio-label">
                            <input type="radio" name="main_image_id" value="{{ $image->image_id }}"
                                {{ $image->is_main ? 'checked' : '' }}>
                            Main Image
                        </label>
                    </div>
                @empty
                    <p class="muted-text">No images</p>
                @endforelse
            </div>
        </div>

        <div class="form-group">
            <label>Add New Product Images</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>

       <div class="image-panel">
    <label>Current Gallery Images</label>

    <div class="image-grid">
        @forelse ($product->galleryImages as $image)
            <div class="image-box">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery image">

                <label class="delete-image-label">
                    <input 
                        type="checkbox" 
                        name="delete_gallery_images[]" 
                        value="{{ $image->image_id }}"
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
            <small>สามารถอัปโหลดได้หลายรูป เพื่อใช้แสดงเป็น gallery ใต้รูปหลัก</small>
        </div>

        <div class="section-title">Artwork / Template Setting</div>

        <div class="checkbox-grid">
             <label><input type="checkbox" name="product_recomend" value="1" {{ old('product_recomend', $product->product_recomend) ? 'checked' : '' }}> Product Recommend</label>
             <label>
    <input type="checkbox" name="product_recomend_menu" value="1"
        {{ old('product_recomend_menu', $product->product_recomend_menu ?? 0) ? 'checked' : '' }}>
    Product Recommend Menu
</label>
            {{-- <label><input type="checkbox" name="is_antivirus_included" value="1" {{ old('is_antivirus_included', $product->is_antivirus_included) ? 'checked' : '' }}> Antivirus Included</label> --}}
            <label><input type="checkbox" name="can_upload_artwork" value="1" {{ old('can_upload_artwork', $product->can_upload_artwork ?? 0) ? 'checked' : '' }}> Allow Upload Artwork</label>
            <label><input type="checkbox" name="artwork_required" value="1" {{ old('artwork_required', $product->artwork_required ?? 0) ? 'checked' : '' }}> Artwork Required</label>
            <label><input type="checkbox" name="allow_text_print" value="1" {{ old('allow_text_print', $product->allow_text_print ?? 0) ? 'checked' : '' }}> Allow Text Printing</label>
            <label><input type="checkbox" name="allow_font_select" value="1" {{ old('allow_font_select', $product->allow_font_select ?? 0) ? 'checked' : '' }}> Allow Font Selection</label>
            <label><input type="checkbox" name="allow_template_select" value="1" {{ old('allow_template_select', $product->allow_template_select ?? 0) ? 'checked' : '' }}> Allow Template Selection</label>
            {{-- <label><input type="checkbox" name="product_premium" value="1" {{ old('product_premium', $product->product_premium) ? 'checked' : '' }}> Product Premium</label> --}}
        </div>
        <div class="form-group" style="max-width: 20%">
    <label>Status</label>

    <select name="is_active">
        <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>
            Public
        </option>

        <option value="3" {{ old('is_active', $product->is_active) == 3 ? 'selected' : '' }}>
            Draft
        </option>
    </select>
</div>

        {{-- <div class="section-title">Detail Images</div>

        <div class="image-panel">
            <label>Current Detail Images</label>

            <div class="image-grid">
                @forelse ($product->detailImages as $image)
                    <div class="image-box">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Detail image">
                    </div>
                @empty
                    <p class="muted-text">No detail images</p>
                @endforelse
            </div>
        </div>

        <div class="form-group">
            <label>Add New Detail Images</label>
            <input type="file" name="detail_images[]" multiple accept="image/*">
            <small>เพิ่มรูปได้ โดยรวมแล้วควรมีไม่เกิน 10 รูป</small>
        </div> --}}

        <div class="form-actions">
            <a href="{{ route('admin.products.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">Update Product</button>
        </div>
    </form>
</div>

@endsection