@extends('layouts.app')

@section('title', $product->product_name)

@section('content')

<h1>Hotmobily Detail</h1>

<h2>{{ $product->product_name }}</h2>

@if($product->mainImage)
    <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" width="300">
@endif

<p>{{ $product->description }}</p>

@endsection