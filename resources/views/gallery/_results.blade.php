<div class="gallery-grid">
    @forelse($galleries as $gallery)
        <div class="gallery-card js-gallery-open"
            data-gallery-id="{{ $gallery->gallery_id }}"
            data-title="{{ $gallery->title }}"
            data-category="{{ $gallery->category->category_name ?? '-' }}"
            data-material="{{ $gallery->material->material_name ?? '-' }}"
            data-purpose="{{ $gallery->purpose ?? '-' }}"
            data-date="{{ $gallery->gallery_date ? $gallery->gallery_date->format('d/m/Y') : '-' }}"
            data-product-link="{{ $gallery->product_link ?: '#' }}"
            data-cover="{{ $gallery->cover_image ? asset('storage/' . $gallery->cover_image) : asset('assets/images/no-image.png') }}"
            data-images='@json($gallery->images->map(fn($img) => asset('storage/' . $img->image_path))->filter()->values())'>

            <div class="gallery-image-box">
                @if ($gallery->cover_image)
                    <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}">
                @else
                    <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $gallery->title }}">
                @endif

                <div class="gallery-hover-overlay">
                    <div class="gallery-hover-content">
                        <i class="bi bi-search"></i>
                        <span>{{ __('gallery.gallery.view_details') }}</span>
                    </div>
                </div>
            </div>

            <div class="gallery-info">
                <div class="gallery-title">{{ $gallery->title }}</div>
                <div class="gallery-date">
                    {{ __('gallery.gallery.created') }}
                    {{ $gallery->gallery_date ? $gallery->gallery_date->format('d/m/Y') : '-' }}
                </div>
            </div>
        </div>
    @empty
        <div class="gallery-empty">
            No galleries found.
        </div>
    @endforelse
</div>

<div class="gallery-pagination">
    {{ $galleries->links() }}
</div>