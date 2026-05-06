<h1>Option Dependencies</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.option-dependencies.create') }}">
    Add Option Dependency
</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Parent Group</th>
            <th>Parent Option</th>
            <th>Child Group</th>
            <th>Child Option</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($dependencies as $dependency)
            <tr>
                <td>{{ $dependency->dependency_id }}</td>

                <td>
                    {{ $dependency->parentOption->group->group_name ?? '-' }}
                </td>

                <td>
                    {{ $dependency->parentOption->option_name ?? '-' }}
                </td>

                <td>
                    {{ $dependency->childOption->group->group_name ?? '-' }}
                </td>

                <td>
                    {{ $dependency->childOption->option_name ?? '-' }}
                </td>

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

                        <button 
                            type="submit" 
                            onclick="return confirm('Delete this dependency?')"
                        >
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" align="center">
                    No option dependencies found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $dependencies->links() }}