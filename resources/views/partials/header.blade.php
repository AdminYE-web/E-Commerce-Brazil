@php
$currentLocale = app()->getLocale();
$supportedLanguages = config('app.supported_locales', ['pt', 'ja', 'en']);
$languageFlags = config('app.locale_flags', ['pt' => 'br', 'ja' => 'jp', 'en' => 'us']);
$currentLanguage = in_array($currentLocale, $supportedLanguages, true)
? $currentLocale
: config('app.locale', 'pt');
$currentLanguageFlag = $languageFlags[$currentLanguage] ?? 'br';

$cart = session('cart', []);
$cartCount = count($cart);
@endphp



<header class="site-header">
    <div class="announcement-bar" id="announcementBar">
        <div class="announcement-track">
            <span>Sua referência em brindes no Japão, com suporte total em português</span>
            <span>Produção rápida e entrega em todo o Japão. Peça seus brindes personalizados hoje!</span>
            <span>Crie seus brindes personalizados em poucos cliques. Simples, rápido e de alta qualidade.</span>

            {{-- duplicate สำหรับให้วิ่งต่อเนื่องไม่กระตุก --}}
            <span>Sua referência em brindes no Japão, com suporte total em português</span>
            <span>Produção rápida e entrega em todo o Japão. Peça seus brindes personalizados hoje!</span>
            <span>Crie seus brindes personalizados em poucos cliques. Simples, rápido e de alta qualidade.</span>
        </div>
    </div>

    <!-- ================= DESKTOP ================= -->
    <div class="desktop-header d-none d-lg-block">
        <div class="container-fluid p-0">
            <nav class="navbar custom-navbar">

                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="logo-box"></div>
                </a>

                <!-- Menu -->
                <ul class="navbar-nav flex-row main-menu">

                    <li class="nav-item">
                        <button type="button" class="nav-link desktop-menu-toggle " data-target="lanyardMegaMenu">
                            {{ __('messages.header.product') }}<img
                                src="{{ asset('assets/images/icon/Polygon 28.png') }}" alt="" aria-hidden="true"
                                class="desktop-menu-toggle-icon">
                        </button>
                    </li>

                    {{-- <li class="nav-item">
                        <button type="button" class="nav-link desktop-menu-toggle" data-target="otherProductMegaMenu">
                            {{ __('messages.header.other_product') }}
                    </button>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('gallery.index') }}" class="nav-link">
                            {{ __('messages.header.gallery') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('about') }}" class="nav-link">
                            {{ __('messages.header.about_us') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('contact') }}" class="nav-link">
                            {{ __('messages.header.contact_us') }}
                        </a>
                    </li>

                </ul>

                <!-- Search -->
                <form class="search-box" action="{{ route('search.index') }}" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="{{ __('messages.header.search') }}">
                </form>

                <!-- Icons -->
                <div class="header-icons">
                    <!-- <a href="{{ route('contact') }}" class="icon-link">
                        <i class="bi bi-envelope"></i>
                    </a> -->

                    <a href="{{ route('cart.index') }}" class="icon-link cart-icon-link">
                        <i class="bi bi-cart"></i>

                        @if ($cartCount > 0)
                        <span class="cart-count-badge">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                        @endif
                    </a>



                    <a href="{{ auth()->check() ? route('account.index') : route('login') }}"
                        class="icon-link account-icon-link" aria-label="{{ __('messages.footer.account') }}"
                        title="{{ __('messages.footer.account') }}">
                        <img src="{{ asset('assets/images/icon/account-icon.png') }}" alt="">
                    </a>
                    <div class="language-dropdown">
                        <button type="button" class="language-toggle">
                            <span class="fi fi-{{ $currentLanguageFlag }} lang-flag-toggle"></span>
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <div class="language-menu">
                            @foreach ($supportedLanguages as $language)
                            <a href="{{ route('language.switch', $language) }}"
                                class="language-item {{ $currentLanguage === $language ? 'active' : '' }}">
                                <span class="fi fi-{{ $languageFlags[$language] ?? $language }} lang-flag"></span>
                                <span>{{ __("messages.header.language.$language") }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </nav>
        </div>
    </div>

    <div class="desktop-mega-menu-wrap d-none d-lg-block">
        <div class="desktop-mega-menu" id="lanyardMegaMenu">
            <div class="container-fluid mega-menu-container">
                <div class="mega-menu-grid">

                    <!-- column 1 -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">{{ __('messages.header.mega.printed_lanyards') }}</div>
                        <ul class="mega-menu-list">
                            @forelse ($megaType1Products ?? [] as $megaProduct)
                            <li>
                                <a href="{{ route('products.description', $megaProduct->product_code) }}">
                                    {{ $megaProduct->product_name }}
                                </a>
                            </li>
                            @empty
                            <li>
                                <a href="{{ route('products.index', ['type' => 1]) }}">
                                    {{ __('messages.header.view_all') }}
                                </a>
                            </li>
                            @endforelse
                        </ul>

                        <a href="{{ route('products.index') }}"
                            class="mega-menu-view-all">{{ __('messages.header.view_all') }} <i
                                class="bi bi-arrow-right"></i></a>
                    </div>

                    <!-- column 2 -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">{{ __('messages.header.mega.blank_lanyards') }}</div>
                        <ul class="mega-menu-list">
                            @forelse ($megaType2Products ?? [] as $megaProduct)
                            <li>
                                <a href="{{ route('products.description', $megaProduct->product_code) }}">
                                    {{ $megaProduct->product_name }}
                                </a>
                            </li>
                            @empty
                            <li>
                                <a href="{{ route('products.index', ['type' => 2]) }}">
                                    {{ __('messages.header.view_all') }}
                                </a>
                            </li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- card 1 -->
                    @forelse ($megaRecommendType1Products ?? [] as $megaProduct)
                    @php
                    $megaImage = null;

                    if ($megaProduct->mainImage) {
                    $megaImage = asset('storage/' . $megaProduct->mainImage->image_path);
                    } elseif ($megaProduct->detail && $megaProduct->detail->sample_image) {
                    $megaImage = asset('storage/' . $megaProduct->detail->sample_image);
                    } else {
                    $megaImage = asset('images/no-image.png');
                    }
                    @endphp

                    <a href="{{ route('products.description', $megaProduct->product_code) }}"
                        class="mega-product-card">
                        <div class="mega-product-image">
                            <img src="{{ $megaImage }}" alt="{{ $megaProduct->product_name }}">
                        </div>

                        <div class="mega-product-content">
                            <h4>{{ $megaProduct->product_name }}</h4>

                            @if (!empty($megaProduct->description))
                            <p>{{ Str::limit(strip_tags($megaProduct->description), 80) }}</p>
                            @elseif ($megaProduct->detail && !empty($megaProduct->detail->description))
                            <p>{{ Str::limit(strip_tags($megaProduct->detail->description), 80) }}</p>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="mega-product-card">
                        <div class="mega-product-image">
                            <img src="{{ asset('images/no-image.png') }}" alt="No image">
                        </div>

                        <div class="mega-product-content">
                            <h4>{{ __('messages.header.view_all') }}</h4>
                            <p></p>
                        </div>
                    </div>
                    @endforelse

                    <!-- card 2 -->
                    @forelse ($megaRecommendType2Products ?? [] as $megaProduct)
                    @php
                    $megaImage = null;

                    if ($megaProduct->mainImage) {
                    $megaImage = asset('storage/' . $megaProduct->mainImage->image_path);
                    } elseif ($megaProduct->detail && $megaProduct->detail->sample_image) {
                    $megaImage = asset('storage/' . $megaProduct->detail->sample_image);
                    } else {
                    $megaImage = asset('images/no-image.png');
                    }
                    @endphp

                    <a href="{{ route('products.description', $megaProduct->product_code) }}"
                        class="mega-product-card">
                        <div class="mega-product-image">
                            <img src="{{ $megaImage }}" alt="{{ $megaProduct->product_name }}">
                        </div>

                        <div class="mega-product-content">
                            <h4>{{ $megaProduct->product_name }}</h4>

                            @if (!empty($megaProduct->description))
                            <p>{{ Str::limit(strip_tags($megaProduct->description), 80) }}</p>
                            @elseif ($megaProduct->detail && !empty($megaProduct->detail->description))
                            <p>{{ Str::limit(strip_tags($megaProduct->detail->description), 80) }}</p>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="mega-product-card">
                        <div class="mega-product-image">
                            <img src="{{ asset('images/no-image.png') }}" alt="No image">
                        </div>

                        <div class="mega-product-content">
                            <h4>{{ __('messages.header.view_all') }}</h4>
                            <p></p>
                        </div>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
        <div class="desktop-mega-menu" id="otherProductMegaMenu">
            <div class="container-fluid mega-menu-container">
                <div class="mega-menu-grid other-product-grid">

                    <!-- ID Case -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">{{ __('messages.header.mega.id_case') }}</div>
                        <ul class="mega-menu-list">
                            <li><a
                                    href="#">{{ __('messages.header.mega.soft_id_card_holder_horizontal_std_1') }}</a>
                            </li>
                            <li><a
                                    href="#">{{ __('messages.header.mega.soft_id_card_holder_horizontal_std_2') }}</a>
                            </li>
                            <li><a
                                    href="#">{{ __('messages.header.mega.soft_id_card_holder_horizontal_std_3') }}</a>
                            </li>
                            <li><a href="#">{{ __('messages.header.mega.soft_id_card_holder_1n') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.soft_id_card_holder_2n') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.soft_id_card_holder_3n') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.soft_id_card_holder_4n') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.soft_id_card_holder_6n') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.leather_badge_holder') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.rigid_frame_id_card_holder_f001') }}</a>
                            </li>
                            <li><a href="#">{{ __('messages.header.mega.rigid_frame_id_card_holder_f002') }}</a>
                            </li>
                        </ul>

                        <a href="{{ route('products.index') }}" class="mega-menu-view-all">
                            {{ __('messages.header.view_all') }} <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Attachment -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">{{ __('messages.header.mega.attachment') }}</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">{{ __('messages.header.mega.resin_logo_front_keeper') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.snap_yoyo') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.spring_hook') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.oval_spring_hook') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.metal_clip') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.metal_clip_with_pvc_strap') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.a_clip') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.pvc_hook') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.euro_clip_a') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.euro_clip_b') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.euro_clip_c') }}</a></li>
                        </ul>

                        <a href="{{ route('products.index') }}" class="mega-menu-view-all">
                            {{ __('messages.header.view_all') }} <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Badge Reel -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">{{ __('messages.header.mega.badge_reel') }}</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">{{ __('messages.header.mega.black_white_badge_reel') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.carabiner_badge_reel') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.stopper_badge_reel') }}</a></li>
                        </ul>
                    </div>

                    <!-- Other -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">{{ __('messages.header.mega.other') }}</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">{{ __('messages.header.mega.wrist_straps') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.phone_strap_case') }}</a></li>
                            <li><a href="#">{{ __('messages.header.mega.carabiner') }}</a></li>
                        </ul>
                    </div>

                    <!-- Product card -->
                    <div class="mega-product-card other-product-card">
                        <div class="mega-product-image">
                            <img src="{{ asset('assets/images/home/wrist-straps.png') }}"
                                alt="{{ __('messages.header.mega.wrist_straps') }}">
                        </div>

                        <div class="mega-product-content">
                            <h4>{{ __('messages.header.mega.wrist_straps') }}</h4>
                            <p>
                                {{ __('messages.header.mega.wrist_straps_description') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- ================= MOBILE ================= -->
    <div class="mobile-header d-lg-none">
        <div class="mobile-top">
            <!-- Hamburger -->
            <button class="mobile-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                aria-controls="mobileMenu">
                <i class="bi bi-list"></i>
            </button>

            <!-- Logo -->
            <a href="{{ route('home') }}" class="mobile-logo-wrap">
                <div class="logo-box mobile-logo"></div>
            </a>

            <!-- Right icons -->
            <div class="mobile-icons">
                <!-- <a href="{{ route('contact') }}" class="icon-link">
                    <i class="bi bi-envelope"></i>
                </a> -->
                <a href="{{ route('cart.index') }}" class="icon-link cart-icon-link">
                    <i class="bi bi-cart"></i>

                    @if ($cartCount > 0)
                    <span class="cart-count-badge">
                        {{ $cartCount > 99 ? '99+' : $cartCount }}
                    </span>
                    @endif
                </a>
                <a href="{{ auth()->check() ? route('account.index') : route('login') }}"
                    class="icon-link account-icon-link" aria-label="{{ __('messages.footer.account') }}"
                    title="{{ __('messages.footer.account') }}">
                    <img src="{{ asset('assets/images/icon/account-icon.png') }}" alt="">
                </a>

                <div class="language-dropdown">
                    <button type="button" class="language-toggle">
                        <span class="fi fi-{{ $currentLanguageFlag }} lang-flag-toggle"></span>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="language-menu">
                        @foreach ($supportedLanguages as $language)
                        <a href="{{ route('language.switch', $language) }}"
                            class="language-item {{ $currentLanguage === $language ? 'active' : '' }}">
                            <span class="fi fi-{{ $languageFlags[$language] ?? $language }} lang-flag"></span>
                            <span>{{ __("messages.header.language.$language") }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <form class="search-box mobile-search-box d-flex" action="{{ route('search.index') }}" method="GET">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                placeholder="{{ __('messages.header.search') }}">
        </form>
    </div>

</header>


<!-- ================= MOBILE OFFCANVAS MENU ================= -->
<div class="offcanvas offcanvas-start mobile-offcanvas" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header mobile-menu-header">
        <a href="{{ route('home') }}" class="mobile-menu-logo">
            <div class="logo-box"></div>
        </a>

        <button type="button" class="btn-close custom-close" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>

    <div class="offcanvas-body mobile-menu-body">

        <!-- MAIN MENU -->
        <div class="mobile-menu-panel active" id="mainMenuPanel">
            <ul class="mobile-menu-list">
                <li>
                    <button type="button" class="mobile-menu-link open-submenu" data-target="lanyardMenuPanel">
                        <span>{{ __('messages.header.product') }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>




                <li>
                    <a href="#" class="mobile-menu-link"><span>{{ __('messages.header.gallery') }}</span></a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="mobile-menu-link"><span>{{ __('messages.header.about_us') }}</span></a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                        class="mobile-menu-link"><span>{{ __('messages.header.contact_us') }}</span></a>
                </li>




            </ul>
        </div>


        <!-- PRODUCT CATEGORY MENU -->
        <div class="mobile-menu-panel" id="lanyardMenuPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-main-menu">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>{{ __('messages.header.product') }}</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                <li>
                    <button type="button" class="mobile-menu-link fw-light open-submenu" data-target="mobileType1ProductPanel">
                        <span>{{ __('messages.header.printed_lanyards') }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>

                <li>
                    <button type="button" class="mobile-menu-link fw-light open-submenu" data-target="mobileType2ProductPanel">
                        <span>{{ __('messages.header.promotional_goods') }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>
            </ul>
        </div>
        <!-- TYPE 1 PRODUCT LIST -->
        <div class="mobile-menu-panel" id="mobileType1ProductPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-submenu" data-target="lanyardMenuPanel">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>{{ __('messages.header.printed_lanyards') }}</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                @forelse ($megaType1Products ?? [] as $megaProduct)
                <li>
                    <a href="{{ route('products.description', $megaProduct->product_code) }}"
                        class="mobile-menu-link fw-light">
                        <span>{{ $megaProduct->product_name }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                @empty
                <li>
                    <a href="{{ route('products.index', ['product_type' => 1]) }}"
                        class="mobile-menu-link">
                        <span>{{ __('messages.header.view_all') }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                @endforelse
            </ul>
        </div>
        <!-- TYPE 2 PRODUCT LIST -->
        <div class="mobile-menu-panel" id="mobileType2ProductPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-submenu" data-target="lanyardMenuPanel">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>{{ __('messages.header.promotional_goods') }}</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                @forelse ($megaType2Products ?? [] as $megaProduct)
                <li>
                    <a href="{{ route('products.description', $megaProduct->product_code) }}"
                        class="mobile-menu-link fw-light">
                        <span>{{ $megaProduct->product_name }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                @empty
                <li>
                    <a href="{{ route('products.index', ['product_type' => 2]) }}"
                        class="mobile-menu-link">
                        <span>{{ __('messages.header.view_all') }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                @endforelse
            </ul>
        </div>

        <!-- OTHER PRODUCT SUB MENU -->
        <div class="mobile-menu-panel" id="otherProductMenuPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-main-menu">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>{{ __('messages.header.other_product') }}</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                <li><a href="#">{{ __('messages.header.mega.badge_holder') }}</a></li>
                <li><a href="#">{{ __('messages.header.mega.id_card_holder') }}</a></li>
                <li><a href="#">{{ __('messages.header.mega.keychain') }}</a></li>
                <li><a href="#">{{ __('messages.header.mega.wristband') }}</a></li>
            </ul>
        </div>


        <!-- ADDITIONAL SUB MENU -->
        <div class="mobile-menu-panel" id="additionalMenuPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-main-menu">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>{{ __('messages.header.additional_lanyard_details') }}</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                <li><a href="#">{{ __('messages.header.mega.printing_method') }}</a></li>
                <li><a href="#">{{ __('messages.header.mega.material_guide') }}</a></li>
                <li><a href="#">{{ __('messages.header.mega.attachment_options') }}</a></li>
                <li><a href="#">{{ __('messages.header.mega.size_guide') }}</a></li>
            </ul>
        </div>

    </div>
</div>