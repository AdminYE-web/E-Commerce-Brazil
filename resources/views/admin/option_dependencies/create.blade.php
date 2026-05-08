<h1>Add Option Dependency</h1>

<a href="{{ route('admin.option-dependencies.index') }}">
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

<form action="{{ route('admin.option-dependencies.store') }}" method="POST">
    @csrf

    <div>
        <label>Trigger Option</label><br>
        <select name="parent_option_id" required>
            <option value="">-- Select Trigger Option --</option>

            @foreach($options as $option)
                <option 
                    value="{{ $option->option_id }}"
                    {{ old('parent_option_id') == $option->option_id ? 'selected' : '' }}
                >
                    {{ $option->group->group_name ?? '-' }} / {{ $option->option_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Target Type</label><br>
        <select name="target_type" id="target_type" required>
            <option value="option" {{ old('target_type', 'option') == 'option' ? 'selected' : '' }}>
                option - แสดงเฉพาะ option
            </option>

            <option value="group" {{ old('target_type') == 'group' ? 'selected' : '' }}>
                group - แสดงทั้ง group
            </option>
        </select>
    </div>

    <br>

    <div id="target_option_box">
        <label>Target Option</label><br>
        <select name="target_option_id">
            <option value="">-- Select Target Option --</option>

            @foreach($options as $option)
                <option 
                    value="{{ $option->option_id }}"
                    {{ old('target_option_id') == $option->option_id ? 'selected' : '' }}
                >
                    {{ $option->group->group_name ?? '-' }} / {{ $option->option_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div id="target_group_box" style="display:none;">
        <label>Target Group</label><br>
        <select name="target_group_id">
            <option value="">-- Select Target Group --</option>

            @foreach($groups as $group)
                <option 
                    value="{{ $group->option_group_id }}"
                    {{ old('target_group_id') == $group->option_group_id ? 'selected' : '' }}
                >
                    {{ $group->group_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
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

<script>
    function toggleTargetType() {
        const type = document.getElementById('target_type').value;
        const optionBox = document.getElementById('target_option_box');
        const groupBox = document.getElementById('target_group_box');

        if (type === 'group') {
            optionBox.style.display = 'none';
            groupBox.style.display = 'block';
        } else {
            optionBox.style.display = 'block';
            groupBox.style.display = 'none';
        }
    }

    document.getElementById('target_type').addEventListener('change', toggleTargetType);
    toggleTargetType();
</script>