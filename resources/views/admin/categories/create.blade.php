<h1>Add Category</h1>

<a href="{{ route('admin.categories.index') }}">Back</a>

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

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <div>
        <label>Category Code</label><br>
        <input type="text" name="category_code" value="{{ old('category_code') }}">
    </div>

    <br>

    <div>
        <label>Category Name</label><br>
        <input type="text" name="category_name" value="{{ old('category_name') }}">
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