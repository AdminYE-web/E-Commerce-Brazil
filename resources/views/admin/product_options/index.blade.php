<h1>Product Options</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.product-options.create') }}">
    Add Product Option
</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Group</th>
            <th>Option Code</th>
            <th>Option Name</th>
            <th>Additional Price</th>
            <th>Price Type</th>
            <th>Status</th>
            <th>Manage</th>
            <th>Image</th>
        </tr>
    </thead>

    <tbody>
        @forelse($options as $option)
            <tr>
                <td>{{ $option->option_id }}</td>

                <td>{{ $option->group->group_name ?? '-' }}</td>

                <td>{{ $option->option_code }}</td>

                <td>{{ $option->option_name }}</td>

                <td>{{ number_format($option->additional_price, 2) }}</td>

                <td>{{ $option->price_type }}</td>

                <td>{{ $option->is_active ? 'Active' : 'Inactive' }}</td>

                <td>
                    <a href="{{ route('admin.product-options.edit', $option->option_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.product-options.destroy', $option->option_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this product option?')">
                            Delete
                        </button>
                    </form>
                </td>
                <td>
    @if($option->mainImage)
        <img 
            src="{{ asset('storage/' . $option->mainImage->image_path) }}" 
            width="80"
        >
    @else
        -
    @endif
</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" align="center">
                    No product options found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $options->links() }}