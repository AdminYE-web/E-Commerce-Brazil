<h1>Edit Variant</h1>

<h3>Option: {{ $variant->option->option_name ?? '-' }}</h3>

<a href="{{ route('admin.product-options.variants.index', $variant->option_id) }}">
    Back
</a>

<br><br>

@if($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form 
    action="{{ route('admin.product-option-variants.update', $variant->variant_id) }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @method('PUT')

    <div>
        <label>Variant Name</label><br>
        <input 
            type="text" 
            name="variant_name" 
            value="{{ old('variant_name', $variant->variant_name) }}"
        >
    </div>

    <br>

    <div>
        <label>Color Code</label><br>
        <input 
            type="text" 
            name="color_code" 
            value="{{ old('color_code', $variant->color_code) }}"
            placeholder="เช่น #000000"
        >

        <input 
            type="color" 
            value="{{ old('color_code', $variant->color_code ?: '#000000') }}"
            onchange="this.previousElementSibling.value = this.value"
        >
    </div>

    <br>

    <div>
        <label>Current Image</label><br>

        @if($variant->image_path)
            <img 
                src="{{ asset('storage/' . $variant->image_path) }}" 
                width="100"
                style="display:block; margin-bottom:10px;"
            >
        @else
            <span>No image</span>
        @endif
    </div>

    <br>

    <div>
        <label>Change Variant Image</label><br>
        <input type="file" name="image_path" accept="image/*">
    </div>

    <br>

    <div>
        <label>Additional Price</label><br>
        <input 
            type="number" 
            step="0.01" 
            name="additional_price" 
            value="{{ old('additional_price', $variant->additional_price) }}"
        >
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input 
            type="number" 
            name="sort_order" 
            value="{{ old('sort_order', $variant->sort_order) }}"
        >
    </div>

    <br>

    <div>
        <label>
            <input 
                type="checkbox" 
                name="is_default" 
                value="1"
                {{ old('is_default', $variant->is_default) ? 'checked' : '' }}
            >
            Default
        </label>
    </div>

    <br>

    <div>
        <label>
            <input 
                type="checkbox" 
                name="is_active" 
                value="1"
                {{ old('is_active', $variant->is_active) ? 'checked' : '' }}
            >
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>