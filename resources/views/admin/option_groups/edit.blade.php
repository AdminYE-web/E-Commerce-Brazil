<h1>Edit Option Group</h1>

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

<form action="{{ route('admin.option-groups.update', $group->option_group_id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Group Code</label><br>
        <input
            type="text"
            name="group_code"
            value="{{ old('group_code', $group->group_code) }}">
    </div>

    <br>

    <div>
        <label>Group Name</label><br>
        <input
            type="text"
            name="group_name"
            value="{{ old('group_name', $group->group_name) }}">
    </div>

    <br>

    <div>
        <label>
            <input
                type="checkbox"
                name="is_required"
                value="1"
                {{ old('is_required', $group->is_required) ? 'checked' : '' }}>
            Required
        </label>
    </div>

    <br>

    <div>
        <label>
            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ old('is_active', $group->is_active) ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>