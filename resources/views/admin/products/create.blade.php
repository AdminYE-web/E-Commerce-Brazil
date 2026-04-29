<h1>Add Product</h1>

<form action="{{ route('admin.products.store') }}" method="POST">
    @csrf

    <div>
        <label>Product Code</label><br>
        <input type="text" name="product_code" value="{{ old('product_code') }}">
        @error('product_code')
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

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1" checked>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Save</button>
</form>