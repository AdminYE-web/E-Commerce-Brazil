<h1>Edit Product Option</h1>

<a href="{{ route('admin.product-options.index') }}">
    Back
</a>

<br><br>

@if($errors->any())
    <div style="color:red; margin-bottom: 15px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.product-options.update', $option->option_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Option Group</label><br>
        <select name="option_group_id">
            <option value="">-- Select Group --</option>

            @foreach($groups as $group)
                <option 
                    value="{{ $group->option_group_id }}"
                    {{ old('option_group_id', $option->option_group_id) == $group->option_group_id ? 'selected' : '' }}
                >
                    {{ $group->group_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Option Code</label><br>
        <input 
            type="text" 
            name="option_code" 
            value="{{ old('option_code', $option->option_code) }}"
        >
    </div>

    <br>

    <div>
        <label>Option Name</label><br>
        <input 
            type="text" 
            name="option_name" 
            value="{{ old('option_name', $option->option_name) }}"
        >
    </div>
    <br>

<div>
    <label>Option Detail</label><br>
    <textarea 
        name="option_detail" 
        rows="8"
        style="width:100%;"
        placeholder="เช่น&#10;Model: ID-6_N&#10;Type: Soft Card Holder&#10;Card Size: 91 mm (H) x 55 mm (W)"
    >{{ old('option_detail', $option->option_detail) }}</textarea>

    @error('option_detail')
        <div style="color:red;">{{ $message }}</div>
    @enderror
</div>
<br>

<div>
    <label>Color Code</label><br>
    <input 
        type="text" 
        name="color_code" 
        value="{{ old('color_code', $option->color_code) }}"
        placeholder="เช่น #ff0000"
    >

    <input 
        type="color" 
        value="{{ old('color_code', $option->color_code ?: '#000000') }}"
        onchange="this.previousElementSibling.value = this.value"
    >

    @error('color_code')
        <div style="color:red;">{{ $message }}</div>
    @enderror
</div>
    <br>

    <div>
        <label>Additional Price</label><br>
        <input 
            type="number" 
            step="0.01" 
            name="additional_price" 
            value="{{ old('additional_price', $option->additional_price) }}"
        >
    </div>

    <br>

    <div>
        <label>Price Type</label><br>
        <select name="price_type">
            <option value="per_item" {{ old('price_type', $option->price_type) == 'per_item' ? 'selected' : '' }}>
                per_item - คิดต่อชิ้น
            </option>

            <option value="per_order" {{ old('price_type', $option->price_type) == 'per_order' ? 'selected' : '' }}>
                per_order - คิดต่อออเดอร์
            </option>
        </select>
    </div>

    <br>

    <div>
        <label>
            <input 
                type="checkbox" 
                name="is_active" 
                value="1"
                {{ old('is_active', $option->is_active) ? 'checked' : '' }}
            >
            Active
        </label>
    </div>

    <br>

   

<div>
    <label>Current Images</label><br>

    @if($option->images && $option->images->count())
        @foreach($option->images as $image)
            <div style="display:inline-block; margin-right:10px; margin-bottom:10px; border:1px solid #ddd; padding:8px;">
                <img 
                    src="{{ asset('storage/' . $image->image_path) }}" 
                    width="100"
                    style="display:block; margin-bottom:5px;"
                >

                @if($image->is_main)
                    <small>Main Image</small><br>
                @endif

                <label style="color:red;">
                    <input 
        type="checkbox" 
        name="delete_images[]" 
        value="{{ $image->image_id }}"
    >
                    Remove image
                </label>
            </div>
        @endforeach
    @else
        <span>No images</span>
    @endif
</div>

<br>

<div>
    <label>Add New Option Images</label><br>
    <input type="file" name="images[]" multiple accept="image/*">
</div>

<br>

    <button type="submit">Update</button>
</form>