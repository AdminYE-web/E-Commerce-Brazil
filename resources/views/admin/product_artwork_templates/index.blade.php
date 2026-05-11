<h1>Product Artwork Templates</h1>

<a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
&nbsp;|&nbsp;
<a href="{{ route('admin.product-artwork-templates.create') }}">Add Artwork Template</a>

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
            <th>Product</th>
            <th>Template Name</th>
            <th>Image</th>
            <th>Sort Order</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($templates as $template)
            <tr>
                <td>{{ $template->template_id }}</td>

                <td>
                    {{ $template->product->product_name ?? '-' }}
                </td>

                <td>
                    {{ $template->template_name }}
                </td>

                <td>
                    @if($template->image_path)
                        <img 
                            src="{{ asset('storage/' . $template->image_path) }}" 
                            width="120"
                            style="max-height:70px; object-fit:contain;"
                        >
                    @else
                        No image
                    @endif
                </td>

                <td>{{ $template->sort_order }}</td>

                <td>{{ $template->is_active ? 'Active' : 'Inactive' }}</td>

                <td>
                    <a href="{{ route('admin.product-artwork-templates.edit', $template->template_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.product-artwork-templates.destroy', $template->template_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this template?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" align="center">
                    No artwork templates found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $templates->links() }}