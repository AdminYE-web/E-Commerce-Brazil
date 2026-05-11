<h1>Add Product</h1>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

<div>
    <label>Product Main Images</label><br>
    <input type="file" name="images[]" multiple accept="image/*">
</div>

<br>

<div>
    <label>Product Gallery Images</label><br>
    <input type="file" name="gallery_images[]" multiple accept="image/*">
</div>
    <div>
        <label>Product Code</label><br>
        <input type="text" name="product_code" value="{{ old('product_code') }}">
        @error('product_code')
        <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>
    <div>
    <label>Product Type</label><br>
    <select name="product_type">
        <option value="1" {{ old('product_type', 1) == 1 ? 'selected' : '' }}>
            hotstrap
        </option>
        <option value="2" {{ old('product_type') == 2 ? 'selected' : '' }}>
            hotmobily
        </option>
    </select>

    @error('product_type')
        <div style="color:red;">{{ $message }}</div>
    @enderror
</div>

<br>
    <div>
    <label>Category</label><br>
    <select name="category_id">
        <option value="">-- Select Category --</option>

        @foreach($categories as $category)
            <option 
                value="{{ $category->category_id }}"
                {{ old('category_id') == $category->category_id ? 'selected' : '' }}
            >
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <div style="color:red;">{{ $message }}</div>
    @enderror
</div>

<br>

<div>
    <label>Material</label><br>
    <select name="material_id">
        <option value="">-- Select Material --</option>

        @foreach($materials as $material)
            <option 
                value="{{ $material->material_id }}"
                {{ old('material_id') == $material->material_id ? 'selected' : '' }}
            >
                {{ $material->material_name }}
            </option>
        @endforeach
    </select>

    @error('material_id')
        <div style="color:red;">{{ $message }}</div>
    @enderror
</div>

<br>

    <div>
        <label>Product Name</label><br>
        <input type="text" name="product_name" value="{{ old('product_name') }}">
        @error('product_name')
        <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_antivirus_included" value="1">
            Antivirus Included
        </label>
    </div>

    <br>
    <hr>

<h3>Artwork / Template Setting</h3>

<div>
    <label>
        <input 
            type="checkbox" 
            name="can_upload_artwork" 
            value="1"
            {{ old('can_upload_artwork', $product->can_upload_artwork ?? 0) ? 'checked' : '' }}
        >
        Allow Upload Artwork
    </label>
</div>

<br>

<div>
    <label>
        <input 
            type="checkbox" 
            name="artwork_required" 
            value="1"
            {{ old('artwork_required', $product->artwork_required ?? 0) ? 'checked' : '' }}
        >
        Artwork Required
    </label>
</div>

<br>

<div>
    <label>
        <input 
            type="checkbox" 
            name="allow_no_artwork" 
            value="1"
            {{ old('allow_no_artwork', $product->allow_no_artwork ?? 1) ? 'checked' : '' }}
        >
        Allow “No Artwork”
    </label>
</div>

<br>

<div>
    <label>
        <input 
            type="checkbox" 
            name="allow_text_print" 
            value="1"
            {{ old('allow_text_print', $product->allow_text_print ?? 0) ? 'checked' : '' }}
        >
        Allow Text Printing
    </label>
</div>

<br>

<div>
    <label>
        <input 
            type="checkbox" 
            name="allow_font_select" 
            value="1"
            {{ old('allow_font_select', $product->allow_font_select ?? 0) ? 'checked' : '' }}
        >
        Allow Font Selection
    </label>
</div>

<br>

<div>
    <label>
        <input 
            type="checkbox" 
            name="allow_template_select" 
            value="1"
            {{ old('allow_template_select', $product->allow_template_select ?? 0) ? 'checked' : '' }}
        >
        Allow Template Selection
    </label>
</div>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1" checked>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Save</button>
</form>