<h1>Add Product Option</h1>

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

<form action="{{ route('admin.product-options.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Option Group</label><br>
        <select name="option_group_id">
            <option value="">-- Select Group --</option>

            @foreach($groups as $group)
                <option 
                    value="{{ $group->option_group_id }}"
                    {{ old('option_group_id') == $group->option_group_id ? 'selected' : '' }}
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
            value="{{ old('option_code') }}"
            placeholder="เช่น HARD, SOFT, WHITE_BACK"
        >
    </div>

    <br>

    <div>
        <label>Option Name</label><br>
        <input 
            type="text" 
            name="option_name" 
            value="{{ old('option_name') }}"
            placeholder="เช่น แบบแข็ง"
        >
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
        <label>Price Type</label><br>
        <select name="price_type">
            <option value="per_item" {{ old('price_type') == 'per_item' ? 'selected' : '' }}>
                per_item - คิดต่อชิ้น
            </option>
            <option value="per_order" {{ old('price_type') == 'per_order' ? 'selected' : '' }}>
                per_order - คิดต่อออเดอร์
            </option>
        </select>
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1" checked>
            Active
        </label>
    </div>

    <br>
    <div>
    <label>Option Images</label><br>
    <input type="file" name="images[]" multiple accept="image/*">
</div>

    <button type="submit">Save</button>
</form>