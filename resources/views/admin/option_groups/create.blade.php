<h1>Add Option Group</h1>

<a href="{{ route('admin.option-groups.index') }}">
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

<form action="{{ route('admin.option-groups.store') }}" method="POST">
    @csrf

    <div>
        <label>Group Code</label><br>
        <input
            type="text"
            name="group_code"
            value="{{ old('group_code') }}"
            placeholder="เช่น pouch_type">
    </div>

    <br>

    <div>
        <label>Group Name</label><br>
        <input
            type="text"
            name="group_name"
            value="{{ old('group_name') }}"
            placeholder="เช่น ประเภทซอง">
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_required" value="1">
            Required
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