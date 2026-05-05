<h1>Categories</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.categories.create') }}">Add Category</a>

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
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->category_id }}</td>
                <td>{{ $category->category_code }}</td>
                <td>{{ $category->category_name }}</td>
                <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->category_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.categories.destroy', $category->category_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this category?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" align="center">No categories found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $categories->links() }}