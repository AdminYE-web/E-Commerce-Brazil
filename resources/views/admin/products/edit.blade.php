<h1>Edit Product</h1>

<a href="{{ route('admin.products.index') }}">
    Back
</a>

<br><br>

@if ($errors->any())
    <div style="color:red; margin-bottom: 15px;">
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

    <div>
        <label>Product Code</label><br>
        <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}">
    </div>

    <br>
    <div>
    <label>Product Type</label><br>
    <select name="product_type">
        <option value="1" {{ old('product_type', $product->product_type) == 1 ? 'selected' : '' }}>
            hotstrap
        </option>
        <option value="2" {{ old('product_type', $product->product_type) == 2 ? 'selected' : '' }}>
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

            @foreach ($categories as $category)
                <option value="{{ $category->category_id }}"
                    {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
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

            @foreach ($materials as $material)
                <option value="{{ $material->material_id }}"
                    {{ old('material_id', $product->material_id) == $material->material_id ? 'selected' : '' }}>
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
        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}">
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>
    </div>

    <br>

    <div>
    <label>Current Images</label><br>

    @if ($product->images && $product->images->count())
        @foreach ($product->images as $image)
            <div style="display:inline-block; margin-right:10px; margin-bottom:10px;">
                <img 
                    src="{{ asset('storage/' . $image->image_path) }}" 
                    width="100"
                    style="display:block; margin-bottom:5px;"
                >

                <label>
                    <input 
                        type="radio" 
                        name="main_image_id" 
                        value="{{ $image->image_id }}"
                        {{ $image->is_main ? 'checked' : '' }}
                    >
                    Main Image
                </label>
            </div>
        @endforeach
    @else
        <span>No images</span>
    @endif
</div>

    <br>

    <div>
        <label>Add New Product Images</label><br>
        <input type="file" name="images[]" multiple accept="image/*">
    </div>

    <br>
    <br>

<div>
    <label>Current Gallery Images</label><br>

    @if ($product->galleryImages && $product->galleryImages->count())
        @foreach ($product->galleryImages as $image)
            <div style="display:inline-block; margin-right:10px; margin-bottom:10px;">
                <img 
                    src="{{ asset('storage/' . $image->image_path) }}" 
                    width="100"
                    style="display:block; margin-bottom:5px;"
                >
            </div>
        @endforeach
    @else
        <span>No gallery images</span>
    @endif
</div>

<br>

<div>
    <label>Add Gallery Images</label><br>
    <input type="file" name="gallery_images[]" multiple accept="image/*">
    <br>
    <small>สามารถอัปโหลดได้หลายรูป เพื่อใช้แสดงเป็น gallery ใต้รูปหลัก</small>
</div>

<br>

    <div>
        <label>
            <input type="checkbox" name="is_antivirus_included" value="1"
                {{ old('is_antivirus_included', $product->is_antivirus_included) ? 'checked' : '' }}>
            Antivirus Included
        </label>
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <br>
    <div>
        <label>Current Detail Images</label><br>

        @if ($product->detailImages && $product->detailImages->count())
            @foreach ($product->detailImages as $image)
                <div style="display:inline-block; margin-right:10px; margin-bottom:10px;">
                    <img src="{{ asset('storage/' . $image->image_path) }}" width="100"
                        style="display:block; margin-bottom:5px;">
                </div>
            @endforeach
        @else
            <span>No detail images</span>
        @endif
    </div>

    <br>

    <div>
        <label>Add New Detail Images</label><br>
        <input type="file" name="detail_images[]" multiple accept="image/*">
        <br>
        <small>เพิ่มรูปได้ โดยรวมแล้วควรมีไม่เกิน 10 รูป</small>
    </div>

    <button type="submit">Update</button>
</form>
