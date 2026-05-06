<h1>Edit Option Dependency</h1>

<a href="{{ route('admin.option-dependencies.index') }}">
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

<form action="{{ route('admin.option-dependencies.update', $dependency->dependency_id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Parent Option</label><br>
        <select name="parent_option_id">
            <option value="">-- Select Parent Option --</option>

            @foreach($options as $option)
                <option 
                    value="{{ $option->option_id }}"
                    {{ old('parent_option_id', $dependency->parent_option_id) == $option->option_id ? 'selected' : '' }}
                >
                    {{ $option->group->group_name ?? '-' }} / {{ $option->option_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Child Option</label><br>
        <select name="child_option_id">
            <option value="">-- Select Child Option --</option>

            @foreach($options as $option)
                <option 
                    value="{{ $option->option_id }}"
                    {{ old('child_option_id', $dependency->child_option_id) == $option->option_id ? 'selected' : '' }}
                >
                    {{ $option->group->group_name ?? '-' }} / {{ $option->option_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <button type="submit">
        Update
    </button>
</form>