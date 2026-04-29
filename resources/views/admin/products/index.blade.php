<h1>Products</h1>

<a href="{{ route('admin.products.create') }}">
    Add Product
</a>

@if(session('success'))
<div style="color: green;">
    {{ session('success') }}
</div>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Product Name</th>
            <th>Antivirus Included</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->product_id }}</td>
            <td>{{ $product->product_code }}</td>
            <td>{{ $product->product_name }}</td>
            <td>
                {{ $product->is_antivirus_included ? 'Yes' : 'No' }}
            </td>
            <td>
                {{ $product->is_active ? 'Active' : 'Inactive' }}
            </td>
            <td>
                <a href="{{ route('admin.products.edit', $product->product_id) }}">
                    Edit
                </a>

                <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Delete this product?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}