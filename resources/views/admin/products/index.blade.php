<h1>Products</h1>

<a href="{{ route('admin.products.create') }}">
    Add Product
</a>

@if (session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Product Type</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Material</th>
            <th>Antivirus Included</th>
            <th>Status</th>
            <th>Manage</th>
            <th>Image</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->product_code }}</td>
                <td>
                    @if ($product->product_type == 1)
                        hotstrap
                    @elseif($product->product_type == 2)
                        hotmobily
                    @else
                        -
                    @endif
                </td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->category->category_name ?? '-' }}</td>
                <td>{{ $product->material->material_name ?? '-' }}</td>
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
                    @if ($product->detail)
                        <a href="{{ route('admin.product-details.edit', $product->detail->product_detail_id) }}">
                            Edit Detail
                        </a>
                    @else
                        <a href="{{ route('admin.product-details.create', ['product_id' => $product->product_id]) }}">
                            Add Detail
                        </a>
                    @endif

                    <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this product?')">
                            Delete
                        </button>
                    </form>
                </td>
                <td>
                    @if ($product->mainImage)
                        <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" width="80">
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}
