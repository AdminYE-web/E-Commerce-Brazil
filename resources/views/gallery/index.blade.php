@extends('layouts.app')

@section('title', 'Gallery')

@section('css')
    <style>
        .gallery-page {
            background: #fff;
            /* padding: 36px 0 70px; */
        }

       :root {
    --header-height: 89px;
}

/* ตัวหลอกพื้นที่ ตอน filter กลายเป็น fixed */
.gallery-filter-placeholder {
    display: none;
}

/* Filter wrapper ปกติ */
.gallery-filter-wrap {
    position: relative;
    z-index: 900;

    background: #f4f4f4;
    border-radius: 9px;
    padding: 19px 30px;
    margin-bottom: 30px;

    transition: border-radius 0.35s ease, box-shadow 0.35s ease;
}

/* ตอน filter ติดใต้ header */
.gallery-filter-wrap.is-fixed-filter {
    position: fixed;
    top: var(--header-height);
    left: var(--filter-left);
    width: var(--filter-width);
    z-index: 999;

    border-radius: 0;
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.04);
    margin-bottom: 0;
}

/* background เต็มจอ ตอน fixed */
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

.gallery-filter-wrap.is-fixed-filter::before {
    transform: translateX(-50%) scaleX(1);
    opacity: 1;
}

/* Form */
.gallery-filter-form {
    position: relative;
    z-index: 1;

    display: grid;
    grid-template-columns: repeat(4, 1fr) auto;
    gap: 24px;
    align-items: center;
}

/* Select */
.gallery-filter-select {
    width: 100%;
    height: 51px;
    border: 0;
    border-radius: 9px;
    background-color: #fff;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23111111' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 18px center;
    background-size: 15px;
    padding: 0 40px 0 18px;
    font-size: 15px;
    color: #111;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
}

.gallery-filter-select.placeholder-active {
    color: #999;
}

.gallery-filter-select.placeholder-active option {
    color: #111;
}

/* Clear filter */
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

/* Tablet */
@media (max-width: 1100px) {
    .gallery-filter-form {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile */
@media (max-width: 768px) {
    .gallery-filter-wrap {
        position: relative;
        top: auto;
        left: auto;
        width: auto;
        z-index: auto;

        padding: 18px 18px 22px;
        border-radius: 18px;
        box-shadow: none;
        background: #f4f4f4;
    }

    .gallery-filter-wrap.is-fixed-filter {
        position: relative;
        top: auto;
        left: auto;
        width: auto;
        border-radius: 18px;
        box-shadow: none;
    }

    .gallery-filter-wrap::before {
        display: none;
    }

    .gallery-filter-form {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        align-items: center;
    }

    .gallery-filter-select {
        border-radius: 12px;
        height: 48px;
    }

    .gallery-filter-form select[name="category_id"],
    .gallery-filter-form select[name="material_id"],
    .gallery-filter-form select[name="purpose"] {
        grid-column: span 2;
    }

    .gallery-filter-form select[name="sort"] {
        grid-column: 1 / 2;
        max-width: 100%;
    }

    .clear-filter-link {
        grid-column: 2 / 3;
        justify-self: center;
        margin-left: auto;
        margin-right: auto;
        font-size: 15px;
    }
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
                padding: 18px 18px 22px;
                border-radius: 18px;
                box-shadow: none;
                background: #f4f4f4;
            }

            .gallery-filter-wrap::before {
                display: none;
            }

            .gallery-filter-wrap.is-sticky-full {
                border-radius: 18px;
                box-shadow: none;
            }

            .gallery-filter-form {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
                align-items: center;
            }

            .gallery-filter-select {
                border-radius: 12px;
                height: 48px;
            }

            .gallery-filter-form select[name="category_id"],
            .gallery-filter-form select[name="material_id"],
            .gallery-filter-form select[name="purpose"] {
                grid-column: span 2;
            }

            .gallery-filter-form select[name="sort"] {
                grid-column: 1 / 2;
                max-width: 100%;
            }

            .clear-filter-link {
                grid-column: 2 / 3;
                justify-self: center;
                margin-left: auto;
                margin-right: auto;
                font-size: 15px;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .gallery-title {
                font-size: 15px;
            }

            .gallery-date {
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
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

        #galleryResults {
    transition: opacity 0.2s ease;
}

#galleryResults.is-loading {
    opacity: 0.45;
    pointer-events: none;
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
                        <option value="">{{ __('gallery.gallery.all_creations') }}</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}"
                                {{ (string) $categoryId === (string) $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="material_id" class="gallery-filter-select js-auto-submit {{ empty($materialId) ? 'placeholder-active' : '' }}">
                        <option value="">{{ __('gallery.gallery.material') }}</option>

                        @foreach ($materials as $material)
                            <option value="{{ $material->material_id }}"
                                {{ (string) $materialId === (string) $material->material_id ? 'selected' : '' }}>
                                {{ $material->material_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="purpose" class="gallery-filter-select js-auto-submit {{ empty($purpose) ? 'placeholder-active' : '' }}">
                        <option value="">{{ __('gallery.gallery.purpose') }}</option>

                        @foreach ($purposes as $purposeItem)
                            <option value="{{ $purposeItem }}" {{ $purpose === $purposeItem ? 'selected' : '' }}>
                                {{ $purposeItem }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sort" class="gallery-filter-select js-auto-submit">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>
                            {{ __('gallery.gallery.latest') }}
                        </option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>
                            {{ __('gallery.gallery.oldest') }}
                        </option>
                    </select>

                    <a href="{{ route('gallery.index') }}" class="clear-filter-link">
                        {{ __('gallery.gallery.clear_filter') }}
                    </a>
                </form>
            </div>

            <div id="galleryResults">
    @include('gallery._results', ['galleries' => $galleries])
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
                            <div>{{ __('gallery.gallery.category') }}</div>
                            <div id="galleryModalCategory"></div>
                        </div>

                        <div class="gallery-detail-row">
                            <div>{{ __('gallery.gallery.materials') }}</div>
                            <div id="galleryModalMaterial"></div>
                        </div>

                        <div class="gallery-detail-row">
                            <div>{{ __('gallery.gallery.purpose') }}</div>
                            <div id="galleryModalPurpose"></div>
                        </div>

                        <div class="gallery-detail-row">
                            <div>{{ __('gallery.gallery.created') }}</div>
                            <div id="galleryModalDate"></div>
                        </div>
                    </div>

                    <a href="#" class="gallery-modal-primary-btn" id="galleryModalProductLink">
                        {{ __('gallery.gallery.view_details') }}
                    </a>

                    <a href="{{ route('contact') }}" target="_blank" rel="noopener" class="gallery-modal-outline-btn">
                        {{ __('gallery.gallery.contact_us') }}
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
        const resultsWrap = document.getElementById('galleryResults');
        const clearBtn = document.querySelector('.clear-filter-link');

        if (!form || !resultsWrap) return;

        function buildUrlFromForm() {
            const formData = new FormData(form);
            const params = new URLSearchParams();

            formData.forEach(function(value, key) {
                if (value !== '') {
                    params.append(key, value);
                }
            });

            const queryString = params.toString();
            const baseUrl = form.getAttribute('action');

            return queryString ? baseUrl + '?' + queryString : baseUrl;
        }

        function updatePlaceholderColor() {
            document.querySelectorAll('.gallery-filter-select').forEach(function(select) {
                if (select.value === '') {
                    select.classList.add('placeholder-active');
                } else {
                    select.classList.remove('placeholder-active');
                }
            });
        }

        function loadGallery(url, pushState = true) {
            resultsWrap.classList.add('is-loading');

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Ajax request failed');
                }

                return response.json();
            })
            .then(function(data) {
                resultsWrap.innerHTML = data.html;

                if (pushState) {
                    window.history.pushState({}, '', url);
                }

                updatePlaceholderColor();
            })
            .catch(function(error) {
                console.error(error);
            })
            .finally(function() {
                resultsWrap.classList.remove('is-loading');
            });
        }

        document.querySelectorAll('.js-auto-submit').forEach(function(select) {
            select.addEventListener('change', function() {
                const url = buildUrlFromForm();
                loadGallery(url);
            });
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();

                form.querySelectorAll('select').forEach(function(select) {
                    if (select.name === 'sort') {
                        select.value = 'newest';
                    } else {
                        select.value = '';
                    }
                });

                const url = form.getAttribute('action');
                loadGallery(url);
            });
        }

        document.addEventListener('click', function(e) {
            const paginationLink = e.target.closest('.gallery-pagination a');

            if (!paginationLink) return;

            e.preventDefault();

            loadGallery(paginationLink.href);
        });

        window.addEventListener('popstate', function() {
            loadGallery(window.location.href, false);
        });

        updatePlaceholderColor();
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

           document.addEventListener('click', function(e) {
    const card = e.target.closest('.js-gallery-open');

    if (!card) return;

    openModal(card);
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
    document.addEventListener('DOMContentLoaded', function() {
        const filterWrap = document.querySelector('.gallery-filter-wrap');

        if (!filterWrap) return;

        const placeholder = document.createElement('div');
        placeholder.className = 'gallery-filter-placeholder';
        filterWrap.parentNode.insertBefore(placeholder, filterWrap);

        let filterStartTop = 0;

        function isMobile() {
            return window.innerWidth <= 768;
        }

        function getHeaderHeight() {
            const header = document.querySelector('header');

            if (!header) {
                return 89;
            }

            return header.offsetHeight;
        }

        function updateSizes() {
            const headerHeight = getHeaderHeight();

            document.documentElement.style.setProperty(
                '--header-height',
                headerHeight + 'px'
            );

            if (!filterWrap.classList.contains('is-fixed-filter')) {
                const rect = filterWrap.getBoundingClientRect();

                filterStartTop = window.scrollY + rect.top;

                document.documentElement.style.setProperty(
                    '--filter-left',
                    rect.left + 'px'
                );

                document.documentElement.style.setProperty(
                    '--filter-width',
                    rect.width + 'px'
                );
            } else {
                const placeholderRect = placeholder.getBoundingClientRect();

                document.documentElement.style.setProperty(
                    '--filter-left',
                    placeholderRect.left + 'px'
                );

                document.documentElement.style.setProperty(
                    '--filter-width',
                    placeholderRect.width + 'px'
                );
            }

            return headerHeight;
        }

        function toggleFixedFilter() {
            const headerHeight = updateSizes();

            if (isMobile()) {
                filterWrap.classList.remove('is-fixed-filter');
                placeholder.style.display = 'none';
                placeholder.style.height = '0px';
                return;
            }

            if (window.scrollY >= filterStartTop - headerHeight) {
                placeholder.style.display = 'block';
                placeholder.style.height = filterWrap.offsetHeight + 'px';

                filterWrap.classList.add('is-fixed-filter');
            } else {
                filterWrap.classList.remove('is-fixed-filter');

                placeholder.style.display = 'none';
                placeholder.style.height = '0px';
            }
        }

        updateSizes();
        toggleFixedFilter();

        window.addEventListener('scroll', toggleFixedFilter, {
            passive: true
        });

        window.addEventListener('resize', function() {
            filterWrap.classList.remove('is-fixed-filter');
            placeholder.style.display = 'none';
            placeholder.style.height = '0px';

            updateSizes();
            toggleFixedFilter();
        });
    });
</script>
@endsection
