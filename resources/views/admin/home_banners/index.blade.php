<h1>Home Banners</h1>

<a href="{{ route('admin.home-banners.create') }}">
    Add Banner
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
            <th>PC Image</th>
            <th>Mobile Image</th>
            <th>Title</th>
            <th>Link</th>
            <th>Sort</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($banners as $banner)
            <tr>
                <td>{{ $banner->home_banner_id }}</td>

                <td>
                    @if($banner->image_pc)
                        <img src="{{ asset('storage/' . $banner->image_pc) }}" width="160">
                    @else
                        No image
                    @endif
                </td>

                <td>
                    @if($banner->image_mobile)
                        <img src="{{ asset('storage/' . $banner->image_mobile) }}" width="90">
                    @else
                        No image
                    @endif
                </td>

                <td>{{ $banner->title ?? '-' }}</td>

                <td>
                    @if($banner->link_url)
                        <a href="{{ $banner->link_url }}" target="_blank">
                            {{ $banner->link_url }}
                        </a>
                    @else
                        -
                    @endif
                </td>

                <td>{{ $banner->sort_order }}</td>

                <td>{{ $banner->is_active ? 'Active' : 'Inactive' }}</td>

                <td>
                    <a href="{{ route('admin.home-banners.edit', $banner->home_banner_id) }}">
                        Edit
                    </a>

                    <form action="{{ route('admin.home-banners.destroy', $banner->home_banner_id) }}"
                        method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Delete this banner?')">
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

{{ $banners->links() }}