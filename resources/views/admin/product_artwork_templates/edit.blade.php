<h1>Edit Product Artwork Template</h1>

<a href="{{ route('admin.product-artwork-templates.index') }}">
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
    action="{{ route('admin.product-artwork-templates.update', $template->template_id) }}" 
    method="POST"
    enctype="multipart/form-data"
>
    @csrf
    @method('PUT')

    <div>
        <label>Product</label><br>
        <select name="product_id" required>
            <option value="">-- Select Product --</option>

            @foreach($products as $product)
                <option 
                    value="{{ $product->product_id }}"
                    {{ old('product_id', $template->product_id) == $product->product_id ? 'selected' : '' }}
                >
                    {{ $product->product_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Template Name</label><br>
        <input 
            type="text" 
            name="template_name" 
            value="{{ old('template_name', $template->template_name) }}"
            style="width:100%;"
            required
        >
    </div>

    <br>

    <div>
        <label>Current Image</label><br>

        @if($template->image_path)
            <img 
                src="{{ asset('storage/' . $template->image_path) }}" 
                width="150"
                style="max-height:100px; object-fit:contain;"
            >
        @else
            No image
        @endif
    </div>

    <br>

    <div>
        <label>Change Image</label><br>
        <input type="file" name="image_path" accept="image/*">
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input 
            type="number" 
            name="sort_order" 
            value="{{ old('sort_order', $template->sort_order) }}"
            min="0"
        >
    </div>

    <br>

    <div>
        <label>
            <input 
                type="checkbox" 
                name="is_active" 
                value="1"
                {{ old('is_active', $template->is_active) ? 'checked' : '' }}
            >
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>