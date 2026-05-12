<h1>Add Material Home</h1>

<a href="{{ route('admin.material-homes.index') }}">
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

<form action="{{ route('admin.material-homes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Material</label><br>
        <select name="material_id">
            <option value="">-- Select Material --</option>

            @foreach($materials as $material)
                <option value="{{ $material->material_id }}"
                    {{ old('material_id') == $material->material_id ? 'selected' : '' }}>
                    {{ $material->material_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title') }}" style="width:400px;">
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description" rows="5" style="width:600px;">{{ old('description') }}</textarea>
    </div>

    <br>

    <div>
        <label>Image</label><br>
        <input type="file" name="image" accept="image/*">
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Save</button>
</form>