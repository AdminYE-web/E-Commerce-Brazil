@forelse($products as $product)
    <div class="product-card">
        <div class="product-image">
            @if($product->mainImage)
                <img 
                    src="{{ asset('storage/' . $product->mainImage->image_path) }}" 
                    alt="{{ $product->product_name }}"
                >
            @else
                <img 
                    src="{{ asset('images/no-image.png') }}" 
                    alt="No image"
                >
            @endif
        </div>

        <div class="product-name">
            {{ $product->product_name }}
        </div>

        <div class="stars">
            ★★★★★
        </div>

      <a href="{{ route('products.description', $product->product_id) }}" class="detail-btn">
    <span>Ver Detalhes</span>
    <span>›</span>
</a>
    </div>
@empty
    <div class="empty-products">
        No products found.
    </div>
@endforelse