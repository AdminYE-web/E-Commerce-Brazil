<h1>Material Home</h1>

<a href="{{ route('admin.material-homes.create') }}">
    Add Material Home
</a>

<br><br>

@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Material</th>
            <th>Title</th>
            <th>Description</th>
            <th>Sort</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->material_home_id }}</td>

                <td>
                    @if($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" width="100">
                    @else
                        No image
                    @endif
                </td>

                <td>
                    {{ $item->material->material_name ?? '-' }}
                </td>

                <td>{{ $item->title }}</td>

                <td>{{ Str::limit($item->description, 80) }}</td>

                <td>{{ $item->sort_order }}</td>

                <td>
                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                </td>

                <td>
                    <a href="{{ route('admin.material-homes.edit', $item->material_home_id) }}">
                        Edit
                    </a>

                    <form action="{{ route('admin.material-homes.destroy', $item->material_home_id) }}"
                        method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Delete this item?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No data</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $items->links() }}