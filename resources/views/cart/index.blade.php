@extends('layouts.app')

@section('title', 'Cart')

@section('content')

<div style="max-width:1000px; margin:40px auto;">
    <h1>Cart</h1>

    @if(session('success'))
        <div style="color:green; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($cart))
        <p>Your cart is empty.</p>
    @else
        @foreach($cart as $item)
            <div style="border:1px solid #ddd; padding:20px; margin-bottom:20px;">
                <h3>{{ $item['product_name'] }}</h3>

                <p>
                    Quantity: {{ $item['quantity'] }}
                </p>

                @if(!empty($item['product_image']))
                    <img 
                        src="{{ asset('storage/' . $item['product_image']) }}" 
                        width="120"
                    >
                @endif

                <h4>Selected Options</h4>

                <ul>
                    @foreach($item['options'] as $option)
                        <li>
                            <strong>{{ $option['group_name'] }}:</strong>
                            {{ $option['option_name'] }}

                            @if(!empty($option['variant_name']))
                                - {{ $option['variant_name'] }}
                            @endif
                        </li>
                    @endforeach

                    @foreach($item['custom_colors'] as $customColor)
                        <li>
                            <strong>{{ $customColor['group_name'] }}:</strong>
                            {{ $customColor['value'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>

@endsection