<h1>Option Variants</h1>

<h3>
    Option: {{ $option->option_name }}
</h3>

<p>
    Group: {{ $option->group->group_name ?? '-' }}
</p>

<a href="{{ route('admin.product-options.index') }}">
    Back to Product Options
</a>

&nbsp;|&nbsp;

<a href="{{ route('admin.product-options.variants.create', $option->option_id) }}">
    Add Variant
</a>

<br><br>

@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Variant Name</th>
            <th>Color</th>
            <th>Additional Price</th>
            <th>Sort</th>
            <th>Default</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($option->variants as $variant)
            <tr>
                <td>{{ $variant->variant_id }}</td>

                <td>
                    @if($variant->image_path)
                        <img 
                            src="{{ asset('storage/' . $variant->image_path) }}" 
                            width="80"
                        >
                    @else
                        -
                    @endif
                </td>

                <td>{{ $variant->variant_name }}</td>

                <td>
                    @if($variant->color_code)
                        <span 
                            style="
                                display:inline-block;
                                width:22px;
                                height:22px;
                                border-radius:50%;
                                background:{{ $variant->color_code }};
                                border:1px solid #ccc;
                                vertical-align:middle;
                            "
                        ></span>
                        {{ $variant->color_code }}
                    @else
                        -
                    @endif
                </td>

                <td>{{ number_format($variant->additional_price, 2) }}</td>

                <td>{{ $variant->sort_order }}</td>

                <td>{{ $variant->is_default ? 'Yes' : 'No' }}</td>

                <td>{{ $variant->is_active ? 'Active' : 'Inactive' }}</td>

                <td>
                    <a href="{{ route('admin.product-option-variants.edit', $variant->variant_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.product-option-variants.destroy', $variant->variant_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this variant?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" align="center">
                    No variants found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>