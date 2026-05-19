@extends('layouts.app')

@section('title', 'Gallery')

@section('css')
    <style>
        .gallery-page {
            background: #fff;
            /* padding: 36px 0 70px; */
        }

        .gallery-filter-wrap {
            position: sticky;
            top: 89px;
            z-index: 50;
            isolation: isolate;

            background: #f4f4f4;
            border-radius: 9px;
            padding: 19px 30px;
            margin-bottom: 30px;

            transition: border-radius 0.35s ease, box-shadow 0.35s ease;
        }

        .gallery-filter-wrap::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 100vw;
            transform: translateX(-50%) scaleX(0);
            transform-origin: center;
            background: #f4f4f4;
            z-index: -1;
            opacity: 0;
            transition: transform 0.45s ease, opacity 0.25s ease;
        }

        .gallery-filter-wrap.is-sticky-full {
            border-radius: 0;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.04);
        }

        .gallery-filter-wrap.is-sticky-full::before {
            transform: translateX(-50%) scaleX(1);
            opacity: 1;
        }

        .gallery-filter-form {
            position: relative;
            z-index: 1;
        }

        .gallery-filter-form {
            display: grid;
            grid-template-columns: repeat(4, 1fr) auto;
            gap: 24px;
            align-items: center;
        }

        .gallery-filter-select {
            width: 100%;
            height: 51px;
            border: 0;
            border-radius: 9px;
            background: #fff;
            padding: 0 18px;
            font-size: 15px;
            color: #111;
            outline: none;
        }

        .clear-filter-link {
            color: #1b93e8;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .gallery-card {
            text-decoration: none;
            color: #111;
            display: block;
        }

        .gallery-image-box {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 14px;
            background: #f4f4f4;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-info {
            padding-top: 12px;
        }

        .gallery-title {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 4px;
            color: #111;
        }

        .gallery-date {
            font-size: 15px;
            color: #111;
        }

        .gallery-empty {
            padding: 40px 0;
            text-align: center;
            color: #777;
            font-size: 16px;
            grid-column: 1 / -1;
        }

        .gallery-pagination {
            margin-top: 34px;
        }

        @media (max-width: 1100px) {
            .gallery-filter-form {
                grid-template-columns: repeat(2, 1fr);
            }

            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .gallery-filter-wrap {
                position: relative;
                top: auto;
                z-index: auto;
                padding: 14px;
                border-radius: 9px;
                box-shadow: none;
            }

            .gallery-filter-wrap::before {
                display: none;
            }

            .gallery-filter-wrap.is-sticky-full {
                border-radius: 9px;
                box-shadow: none;
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }

        .gallery-card {
            text-decoration: none;
            color: #111;
            display: block;
        }

        .gallery-image-box {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 18px;
            background: #f4f4f4;
            overflow: hidden;
            position: relative;
        }

        .gallery-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.35s ease;
        }

        .gallery-hover-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.05));
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 18px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-hover-content {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
        }

        .gallery-hover-content i {
            font-size: 18px;
            line-height: 1;
        }

        .gallery-card:hover .gallery-hover-overlay {
            opacity: 1;
        }

        .gallery-card:hover .gallery-image-box img {
            transform: scale(1.04);
        }

        .gallery-card {
            cursor: pointer;
        }

        .gallery-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.58);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 28px;
        }

        .gallery-modal-backdrop.is-open {
            display: flex;
        }

        .gallery-modal {
            position: relative;
            width: min(1160px, 96vw);
            max-height: 92vh;
            overflow-y: auto;
            background: #fff;
            border-radius: 8px;
            padding: 24px 26px;
        }

        .gallery-modal-close {
            position: absolute;
            top: 10px;
            right: 12px;
            width: 26px;
            height: 26px;
            border: 0;
            border-radius: 50%;
            background: #e5e5e5;
            color: #111;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            z-index: 3;
        }

        .gallery-modal-layout {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 40px;
        }

        .gallery-main-image-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 0.82;
            background: #f5f5f5;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-main-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .gallery-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 54px;
            height: 54px;
            border: 0;
            border-radius: 50%;
            background: rgba(210, 210, 210, 0.75);
            color: #fff;
            font-size: 54px;
            line-height: 0.7;
            cursor: pointer;
            z-index: 2;
        }

        .gallery-arrow-prev {
            left: 12px;
        }

        .gallery-arrow-next {
            right: 12px;
        }

        .gallery-dots {
            display: flex;
            justify-content: center;
            gap: 7px;
            margin: 12px 0 24px;
        }

        .gallery-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #d9d9d9;
        }

        .gallery-dot.active {
            background: #777;
        }

        .gallery-thumbs {
            display: flex;
            gap: 10px;
            overflow-x: auto;
        }

        .gallery-thumb {
            width: 106px;
            height: 82px;
            border: 2px solid transparent;
            border-radius: 5px;
            background: #f5f5f5;
            padding: 0;
            cursor: pointer;
            overflow: hidden;
        }

        .gallery-thumb.active {
            border-color: #1f4fff;
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-modal-right {
            padding: 12px 10px 0;
        }

        .gallery-modal-right h2 {
            font-size: 34px;
            font-weight: 800;
            margin: 0 0 34px;
            color: #000;
        }

        .gallery-detail-table {
            margin-bottom: 34px;
        }

        .gallery-detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 20px;
            font-size: 15px;
            margin-bottom: 26px;
            color: #111;
        }

        .gallery-modal-primary-btn,
        .gallery-modal-outline-btn {
            width: 100%;
            height: 39px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .gallery-modal-primary-btn {
            background: #2f70c9;
            color: #fff;
        }

        .gallery-modal-outline-btn {
            border: 1px solid #d1d5db;
            background: #fff;
            color: #111;
        }

        @media (max-width: 900px) {
            .gallery-modal-layout {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .gallery-modal {
                padding: 20px;
            }

            .gallery-modal-right h2 {
                font-size: 26px;
            }

            .gallery-detail-row {
                grid-template-columns: 120px 1fr;
            }
        }

        .gallery-banner-section {
            margin-bottom: 34px;
        }

        .gallery-banner-section img {
            width: 100%;
            height: auto;
            display: block;
        }
        .gallery-filter-wrap {
    position: sticky;
    top: 89px;
    z-index: 50;
} 
    </style>
@endsection

@section('content')
    @if ($galleryBanners->count())
        <section class="gallery-banner-section">
            <div id="galleryBannerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($galleryBanners as $index => $banner)
                        <button type="button" data-bs-target="#galleryBannerCarousel" data-bs-slide-to="{{ $index }}"
                            class="{{ $index === 0 ? 'active' : '' }}">
                        </button>
                    @endforeach
                </div>

                <div class="carousel-inner rounded-4 overflow-hidden">
                    @foreach ($galleryBanners as $index => $banner)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <a href="{{ $banner->link_url ?: '#' }}">
                                <picture>
                                    @if ($banner->image_mobile)
                                        <source media="(max-width: 768px)"
                                            srcset="{{ asset('storage/' . $banner->image_mobile) }}">
                                    @endif

                                    <img src="{{ asset('storage/' . $banner->image_pc) }}" class="d-block w-100"
                                        alt="{{ $banner->title }}">
                                </picture>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if ($galleryBanners->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#galleryBannerCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#galleryBannerCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif
            </div>
        </section>
    @endif
    <section class="gallery-page">
        <div class="container">

            <div class="gallery-filter-wrap">
                <form method="GET" action="{{ route('gallery.index') }}" class="gallery-filter-form"
                    id="galleryFilterForm">

                    <select name="category_id" class="gallery-filter-select js-auto-submit">
                        <option value="">All Creations</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}"
                                {{ (string) $categoryId === (string) $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="material_id" class="gallery-filter-select js-auto-submit">
                        <option value="">Materiais</option>

                        @foreach ($materials as $material)
                            <option value="{{ $material->material_id }}"
                                {{ (string) $materialId === (string) $material->material_id ? 'selected' : '' }}>
                                {{ $material->material_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="purpose" class="gallery-filter-select js-auto-submit">
                        <option value="">Finalidade</option>

                        @foreach ($purposes as $purposeItem)
                            <option value="{{ $purposeItem }}" {{ $purpose === $purposeItem ? 'selected' : '' }}>
                                {{ $purposeItem }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sort" class="gallery-filter-select js-auto-submit">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>
                            Mais recentes
                        </option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>
                            Mais antigos
                        </option>
                    </select>

                    <a href="{{ route('gallery.index') }}" class="clear-filter-link">
                        ↻ Limpar Filtros
                    </a>
                </form>
            </div>

            <div class="gallery-grid">
                @forelse($galleries as $gallery)
                    <div class="gallery-card js-gallery-open" data-gallery-id="{{ $gallery->gallery_id }}"
                        data-title="{{ $gallery->title }}" data-category="{{ $gallery->category->category_name ?? '-' }}"
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
                                    <span>View detail</span>
                                </div>
                            </div>
                        </div>

                        <div class="gallery-info">
                            <div class="gallery-title">{{ $gallery->title }}</div>
                            <div class="gallery-date">
                                Data: {{ $gallery->gallery_date ? $gallery->gallery_date->format('d/m/Y') : '-' }}
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

        </div>
    </section>
    <div class="gallery-modal-backdrop" id="galleryModal">
        <div class="gallery-modal">
            <button type="button" class="gallery-modal-close" id="galleryModalClose">
                ×
            </button>

            <div class="gallery-modal-layout">
                <div class="gallery-modal-left">
                    <div class="gallery-main-image-wrap">
                        <button type="button" class="gallery-arrow gallery-arrow-prev" id="galleryPrevBtn">
                            ‹
                        </button>

                        <img id="galleryModalMainImage" src="" alt="Gallery image">

                        <button type="button" class="gallery-arrow gallery-arrow-next" id="galleryNextBtn">
                            ›
                        </button>
                    </div>

                    <div class="gallery-dots" id="galleryDots"></div>

                    <div class="gallery-thumbs" id="galleryThumbs"></div>
                </div>

                <div class="gallery-modal-right">
                    <h2 id="galleryModalTitle"></h2>

                    <div class="gallery-detail-table">
                        <div class="gallery-detail-row">
                            <div>Category</div>
                            <div id="galleryModalCategory"></div>
                        </div>

                        <div class="gallery-detail-row">
                            <div>Material</div>
                            <div id="galleryModalMaterial"></div>
                        </div>

                        <div class="gallery-detail-row">
                            <div>Purpose</div>
                            <div id="galleryModalPurpose"></div>
                        </div>

                        <div class="gallery-detail-row">
                            <div>Date</div>
                            <div id="galleryModalDate"></div>
                        </div>
                    </div>

                    <a href="#" class="gallery-modal-primary-btn" id="galleryModalProductLink">
    Ver Detalhes
</a>

                    <a href="{{ route('contact') }}" target="_blank" rel="noopener"
                        class="gallery-modal-outline-btn">
                        Fale conosco
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('galleryFilterForm');

            document.querySelectorAll('.js-auto-submit').forEach(function(select) {
                select.addEventListener('change', function() {
                    form.submit();
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('galleryModal');
            const closeBtn = document.getElementById('galleryModalClose');

            const titleEl = document.getElementById('galleryModalTitle');
            const categoryEl = document.getElementById('galleryModalCategory');
            const materialEl = document.getElementById('galleryModalMaterial');
            const purposeEl = document.getElementById('galleryModalPurpose');
            const dateEl = document.getElementById('galleryModalDate');

            const mainImage = document.getElementById('galleryModalMainImage');
            const thumbsWrap = document.getElementById('galleryThumbs');
            const dotsWrap = document.getElementById('galleryDots');

            const prevBtn = document.getElementById('galleryPrevBtn');
            const nextBtn = document.getElementById('galleryNextBtn');

            const productLinkBtn = document.getElementById('galleryModalProductLink');

            let currentImages = [];
            let currentIndex = 0;

            function renderImage(index) {
                if (!currentImages.length) {
                    return;
                }

                currentIndex = index;

                mainImage.src = currentImages[currentIndex];

                thumbsWrap.querySelectorAll('.gallery-thumb').forEach(function(btn, i) {
                    btn.classList.toggle('active', i === currentIndex);
                });

                dotsWrap.querySelectorAll('.gallery-dot').forEach(function(dot, i) {
                    dot.classList.toggle('active', i === currentIndex);
                });
            }

            function renderThumbs() {
                thumbsWrap.innerHTML = '';
                dotsWrap.innerHTML = '';

                currentImages.forEach(function(image, index) {
                    const thumbBtn = document.createElement('button');
                    thumbBtn.type = 'button';
                    thumbBtn.className = 'gallery-thumb' + (index === 0 ? ' active' : '');
                    thumbBtn.innerHTML = `<img src="${image}" alt="Gallery thumbnail">`;

                    thumbBtn.addEventListener('click', function() {
                        renderImage(index);
                    });

                    thumbsWrap.appendChild(thumbBtn);

                    const dot = document.createElement('span');
                    dot.className = 'gallery-dot' + (index === 0 ? ' active' : '');
                    dotsWrap.appendChild(dot);
                });
            }

            function openModal(card) {
                
                titleEl.textContent = card.dataset.title || '';
                categoryEl.textContent = card.dataset.category || '-';
                materialEl.textContent = card.dataset.material || '-';
                purposeEl.textContent = card.dataset.purpose || '-';
                dateEl.textContent = card.dataset.date || '-';
if (productLinkBtn) {
    productLinkBtn.href = card.dataset.productLink || '#';

    if (!card.dataset.productLink || card.dataset.productLink === '#') {
        productLinkBtn.style.display = 'none';
    } else {
        productLinkBtn.style.display = 'flex';
    }
}
                try {
                    currentImages = JSON.parse(card.dataset.images || '[]');
                } catch (e) {
                    currentImages = [];
                }

                if (!currentImages.length && card.dataset.cover) {
                    currentImages = [card.dataset.cover];
                }

                currentIndex = 0;
                renderThumbs();
                renderImage(0);

                modal.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            document.querySelectorAll('.js-gallery-open').forEach(function(card) {
                card.addEventListener('click', function() {
                    openModal(card);
                });
            });

            closeBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            prevBtn.addEventListener('click', function() {
                if (!currentImages.length) return;

                const nextIndex = currentIndex === 0 ?
                    currentImages.length - 1 :
                    currentIndex - 1;

                renderImage(nextIndex);
            });

            nextBtn.addEventListener('click', function() {
                if (!currentImages.length) return;

                const nextIndex = currentIndex === currentImages.length - 1 ?
                    0 :
                    currentIndex + 1;

                renderImage(nextIndex);
            });

            document.addEventListener('keydown', function(e) {
                if (!modal.classList.contains('is-open')) {
                    return;
                }

                if (e.key === 'Escape') {
                    closeModal();
                }

                if (e.key === 'ArrowLeft') {
                    prevBtn.click();
                }

                if (e.key === 'ArrowRight') {
                    nextBtn.click();
                }
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const filterWrap = document.querySelector('.gallery-filter-wrap');

    if (!filterWrap) return;

    function isMobile() {
        return window.innerWidth <= 768;
    }

    function getHeaderHeight() {
        const header = document.querySelector('header');
        return header ? header.offsetHeight : 89;
    }

    function toggleStickyFull() {
        if (isMobile()) {
            filterWrap.classList.remove('is-sticky-full');
            return;
        }

        const headerHeight = getHeaderHeight();
        const rect = filterWrap.getBoundingClientRect();

        if (rect.top <= headerHeight + 1) {
            filterWrap.classList.add('is-sticky-full');
        } else {
            filterWrap.classList.remove('is-sticky-full');
        }
    }

    toggleStickyFull();

    window.addEventListener('scroll', toggleStickyFull, { passive: true });
    window.addEventListener('resize', toggleStickyFull);
});
</script>
@endsection
