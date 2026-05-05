<h1>Add Material</h1>

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

<form action="{{ route('admin.materials.store') }}" method="POST">
    @csrf

    <div>
        <label>Material Code</label><br>
        <input type="text" name="material_code" value="{{ old('material_code') }}">
    </div>

    <br>

    <div>
        <label>Material Name</label><br>
        <input type="text" name="material_name" value="{{ old('material_name') }}">
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