<h1>Edit Material</h1>

<a href="{{ route('admin.materials.index') }}">Back</a>

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

<form action="{{ route('admin.materials.update', $material->material_id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Material Code</label><br>
        <input 
            type="text" 
            name="material_code" 
            value="{{ old('material_code', $material->material_code) }}"
        >
    </div>

    <br>

    <div>
        <label>Material Name</label><br>
        <input 
            type="text" 
            name="material_name" 
            value="{{ old('material_name', $material->material_name) }}"
        >
    </div>

    <br>

    <div>
        <label>
            <input 
                type="checkbox" 
                name="is_active" 
                value="1"
                {{ old('is_active', $material->is_active) ? 'checked' : '' }}
            >
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>