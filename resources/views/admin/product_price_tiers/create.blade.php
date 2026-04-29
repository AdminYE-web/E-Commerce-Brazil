<h1>Add Product Price Tier</h1>

<a href="{{ route('admin.product-price-tiers.index') }}">
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

<form action="{{ route('admin.product-price-tiers.store') }}" method="POST">
    @csrf

    <div>
        <label>Product</label><br>
        <select name="product_id">
            <option value="">-- Select Product --</option>

            @foreach($products as $product)
            <option
                value="{{ $product->product_id }}"
                {{ old('product_id') == $product->product_id ? 'selected' : '' }}>
                {{ $product->product_name }}
            </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Min Qty</label><br>
        <input type="number" name="min_qty" value="{{ old('min_qty') }}">
    </div>

    <br>

    <div>
        <label>Max Qty</label><br>
        <input type="number" name="max_qty" value="{{ old('max_qty') }}">
        <small>ปล่อยว่าง = ตั้งแต่ Min Qty ขึ้นไป</small>
    </div>

    <br>

    <div>
        <label>Unit Price</label><br>
        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}">
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