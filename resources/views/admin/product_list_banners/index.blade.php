<h1>Product List Banners</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.product-list-banners.create') }}">
    Add Banner
</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Button</th>
            <th>Link</th>
            <th>Sort</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($banners as $banner)
            <tr>
                <td>{{ $banner->banner_id }}</td>

                <td>
                    @if($banner->image_path)
                        <img 
                            src="{{ asset('storage/' . $banner->image_path) }}" 
                            width="120"
                        >
                    @else
                        -
                    @endif
                </td>

                <td>{{ $banner->title }}</td>
                <td>{{ $banner->subtitle }}</td>
                <td>{{ $banner->button_text }}</td>
                <td>{{ $banner->link_url }}</td>
                <td>{{ $banner->sort_order }}</td>
                <td>{{ $banner->is_active ? 'Active' : 'Inactive' }}</td>

                <td>
                    <a href="{{ route('admin.product-list-banners.edit', $banner->banner_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.product-list-banners.destroy', $banner->banner_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this banner?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" align="center">
                    No banners found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $banners->links() }}