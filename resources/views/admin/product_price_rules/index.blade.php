<h1>Product Price Rules</h1>

<a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
&nbsp;|&nbsp;
<a href="{{ route('admin.product-price-rules.create') }}">Add Price Rule</a>

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
            <th>Product</th>
            <th>Rule Name</th>
            <th>Required Options</th>
            <th>Price Tiers</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>

    <tbody>
        @forelse($rules as $rule)
            <tr>
                <td>{{ $rule->rule_id }}</td>

                <td>{{ $rule->product->product_name ?? '-' }}</td>

                <td>{{ $rule->rule_name ?? '-' }}</td>

                <td>
                    @foreach($rule->options as $option)
                        <div>
                            {{ $option->group->group_name ?? '-' }}
                            /
                            <strong>{{ $option->option_name }}</strong>
                        </div>
                    @endforeach
                </td>

                <td>
                    @foreach($rule->tiers as $tier)
                        <div>
                            {{ $tier->min_qty }}
                            -
                            {{ $tier->max_qty ?? 'up' }}
                            =
                            {{ number_format($tier->unit_price, 2) }}
                        </div>
                    @endforeach
                </td>

                <td>{{ $rule->is_active ? 'Active' : 'Inactive' }}</td>

                <td>
                    <a href="{{ route('admin.product-price-rules.edit', $rule->rule_id) }}">
                        Edit
                    </a>

                    <form 
                        action="{{ route('admin.product-price-rules.destroy', $rule->rule_id) }}" 
                        method="POST" 
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Delete this rule?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" align="center">
                    No price rules found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $rules->links() }}