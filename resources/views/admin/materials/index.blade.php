<h1>Materials</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.materials.create') }}">Add Material</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($materials as $material)
            <tr>
                <td>{{ $material->material_id }}</td>
                <td>{{ $material->material_code }}</td>
                <td>{{ $material->material_name }}</td>
                <td>{{ $material->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.materials.edit', $material->material_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.materials.destroy', $material->material_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this material?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" align="center">No materials found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $materials->links() }}