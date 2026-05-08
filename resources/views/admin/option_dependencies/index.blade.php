<h1>Option Dependencies</h1>

<a href="{{ route('admin.dashboard') }}">
    Admin Dashboard
</a>

&nbsp;|&nbsp;

<a href="{{ route('admin.option-dependencies.create') }}">
    Add Dependency
</a>

<br><br>

@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Trigger Option</th>
            <th>Target Type</th>
            <th>Target</th>
            <th>Sort</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($dependencies as $dependency)
            <tr>
                <td>{{ $dependency->dependency_id }}</td>

                <td>
                    {{ $dependency->parentOption->group->group_name ?? '-' }}
                    /
                    <strong>{{ $dependency->parentOption->option_name ?? '-' }}</strong>
                </td>

                <td>{{ $dependency->target_type }}</td>

                <td>
                    @if($dependency->target_type === 'group')
                        Group:
                        <strong>{{ $dependency->targetGroup->group_name ?? '-' }}</strong>
                    @else
                        Option:
                        {{ $dependency->targetOption->group->group_name ?? '-' }}
                        /
                        <strong>{{ $dependency->targetOption->option_name ?? '-' }}</strong>
                    @endif
                </td>

                <td>{{ $dependency->sort_order }}</td>

                <td>{{ $dependency->is_active ? 'Active' : 'Inactive' }}</td>

                <td>
                    <a href="{{ route('admin.option-dependencies.edit', $dependency->dependency_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.option-dependencies.destroy', $dependency->dependency_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this dependency?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" align="center">
                    No dependencies found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $dependencies->links() }}