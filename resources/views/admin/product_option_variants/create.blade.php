<h1>Add Variant</h1>

<h3>Option: {{ $option->option_name }}</h3>

<a href="{{ route('admin.product-options.variants.index', $option->option_id) }}">
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
    action="{{ route('admin.product-options.variants.store', $option->option_id) }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf

    <div>
        <label>Variant Name</label><br>
        <input 
            type="text" 
            name="variant_name" 
            value="{{ old('variant_name') }}"
            placeholder="เช่น Black, White, Red"
        >
    </div>

    <br>

    <div>
        <label>Color Code</label><br>
        <input 
            type="text" 
            name="color_code" 
            value="{{ old('color_code') }}"
            placeholder="เช่น #000000"
        >

        <input 
            type="color" 
            value="{{ old('color_code', '#000000') }}"
            onchange="this.previousElementSibling.value = this.value"
        >
    </div>

    <br>

    <div>
        <label>Variant Image</label><br>
        <input type="file" name="image_path" accept="image/*">
    </div>

    <br>

    <div>
        <label>Additional Price</label><br>
        <input 
            type="number" 
            step="0.01" 
            name="additional_price" 
            value="{{ old('additional_price', 0) }}"
        >
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input 
            type="number" 
            name="sort_order" 
            value="{{ old('sort_order', 0) }}"
        >
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_default" value="1">
            Default
        </label>
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1" checked>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Save</button>
</form>