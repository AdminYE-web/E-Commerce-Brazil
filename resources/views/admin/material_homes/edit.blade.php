<h1>Edit Material Home</h1>

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

<form action="{{ route('admin.material-homes.update', $materialHome->material_home_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Material</label><br>
        <select name="material_id">
            <option value="">-- Select Material --</option>

            @foreach($materials as $material)
                <option value="{{ $material->material_id }}"
                    {{ old('material_id', $materialHome->material_id) == $material->material_id ? 'selected' : '' }}>
                    {{ $material->material_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title', $materialHome->title) }}" style="width:400px;">
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description" rows="5" style="width:600px;">{{ old('description', $materialHome->description) }}</textarea>
    </div>

    <br>

    <div>
        <label>Current Image</label><br>

        @if($materialHome->image_path)
            <img src="{{ asset('storage/' . $materialHome->image_path) }}" width="180">
            <br>

            <label style="color:red;">
                <input type="checkbox" name="remove_image" value="1">
                Remove image
            </label>
        @else
            No image
        @endif
    </div>

    <br>

    <div>
        <label>Upload New Image</label><br>
        <input type="file" name="image" accept="image/*">
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', $materialHome->sort_order) }}" min="0">
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $materialHome->is_active) ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>