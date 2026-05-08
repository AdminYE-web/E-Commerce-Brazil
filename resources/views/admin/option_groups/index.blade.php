<h1>Option Groups</h1>

@if (session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.option-groups.create') }}">
    Add Option Group
</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Group Code</th>
            <th>Group Name</th>
            <th>Parent Group</th>
            <th>Display Type</th>
            <th>Required</th>
            <th>Sort</th>
            <th>Required</th>
            <th>Main Price Group</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($groups as $group)
            <tr>
                <td>{{ $group->option_group_id }}</td>
                <td>{{ $group->group_code }}</td>
                <td>{{ $group->group_name }}</td>
                <td>{{ $group->parent->group_name ?? '-' }}</td>
                <td>{{ $group->display_type }}</td>
                <td>{{ $group->is_required ? 'Yes' : 'No' }}</td>
                <td>{{ $group->option_group_main ? 'Yes' : 'No' }}</td>
                <td>{{ $group->sort_order }}</td>
                <td>{{ $group->is_required ? 'Yes' : 'No' }}</td>
                <td>{{ $group->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.option-groups.edit', $group->option_group_id) }}">
                        Edit
                    </a>

                    <form action="{{ route('admin.option-groups.destroy', $group->option_group_id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this option group?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" align="center">
                    No option groups found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $groups->links() }}
