@forelse($products as $product)
    <div class="product-card">
        <div class="product-image">
            @if ($product->mainImage)
                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" alt="{{ $product->product_name }}">
            @else
                <img src="{{ asset('images/no-image.png') }}" alt="No image">
            @endif
        </div>

        <div class="mh-product">
            <div class="product-name">
                {{ $product->product_name }}
            </div>

            <div class="stars">
                ★★★★★
            </div>
        </div>

        <a href="{{ route('products.description', $product->product_code) }}" class="detail-btn">
            <span>{{ __('product.product_list.detail') }}</span>
            <img src="{{ asset('assets/images/icon/Vector 7.png') }}" alt="" class="detail-btn-icon">
        </a>
    </div>
@empty
    <div class="empty-products">
        No products found.
    </div>
@endforelse
