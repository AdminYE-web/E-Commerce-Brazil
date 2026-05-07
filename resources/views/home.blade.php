@extends('layouts.app')

@section('title', 'Página inicial | Master Brindes')

@section('content')
    <section class="hero-banner">
        <div class="container-fluid p-0">
            <div id="homeBannerCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">

                <div class="carousel-inner">

                    <!-- Banner 1 -->
                    <div class="carousel-item active">
                        <div class="hero-slide">

                            <div class="hero-copy">
                                <h1 class="hero-title">
                                    Padrão Japonês <br>
                                    Estilo Único <br>
                                    Seu Brinde Perfeito
                                </h1>

                                <p class="hero-text">
                                    Manufatura de precisão no Japão com <br>
                                    atendimento 100% em português. <br>
                                    Do design à entrega, a perfeição <br>
                                    que sua ideia merece.
                                </p>

                                <div class="hero-action-group">
                                    <div class="hero-dots-custom">
                                        <button class="active" type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="0"></button>
                                        <button type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="1"></button>
                                    </div>

                                    <a href="#" class="btn hero-cta">
                                        <span>Ver Catálogo</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <img src="{{ asset('assets/images/home/banner_home.png') }}" alt="Banner Home"
                                class="hero-banner-image">

                        </div>
                    </div>

                    <!-- Banner 2 -->
                    <div class="carousel-item">
                        <div class="hero-slide" style="background: #F5CF3C">

                            <div class="hero-copy">
                                <h1 class="hero-head" style="color: black">HOTMOBILY</h1>
                                <h1 class="hero-title" style="color: black">
                                    Estilo que Resiste a Tudo
                                </h1>

                                <p class="hero-text" style="color: black">
                                    Brindes Únicos e Colecionáveis com Estilo Extraordinário
                                </p>

                                <div class="hero-action-group">
                                    <div class="hero-dots-custom">
                                        <button type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="0"></button>
                                        <button class="active" type="button" data-bs-target="#homeBannerCarousel"
                                            data-bs-slide-to="1"></button>
                                    </div>

                                    <a href="#" class="btn hero-cta" style="background: white; color: black">
                                        <span>Ver Catálogo</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <img src="{{ asset('assets/images/home/banner_home_2.png') }}" alt="Banner Home 2"
                                class="hero-banner-image">

                        </div>
                    </div>

                </div>

                <button class="carousel-control-prev hero-control hero-control-prev-custom" type="button"
                    data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
                    <span class="hero-control-icon" aria-hidden="true">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next hero-control hero-control-next-custom" type="button"
                    data-bs-target="#homeBannerCarousel" data-bs-slide="next">
                    <span class="hero-control-icon" aria-hidden="true">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        </div>
    </section>
    <section class="feature-bar">
        <div class="container-fluid">
            <div class="feature-bar-inner">

                <div class="feature-item">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/images/home/hugeicons_checkmark-square-04.png') }}" alt="Pedido fácil">
                    </div>
                    <div class="feature-text">Pedido fácil</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/images/home/Icon.png') }}" alt="Preços mais baixos">
                    </div>
                    <div class="feature-text">Preços mais baixos</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/images/home/material-symbols-light_delivery-truck-speed-outline.png') }}"
                            alt="Entrega expressa rápida">
                    </div>
                    <div class="feature-text">Entrega expressa rápida</div>
                </div>

            </div>
        </div>
    </section>
    <section class="recommended-section">
        <div class="recommended-bg recommended-bg-up"></div>
        <div class="recommended-bg recommended-bg-left"></div>
        <div class="recommended-bg recommended-bg-right-big"></div>
        <div class="recommended-bg recommended-bg-right-small"></div>

        <div class="container recommended-container">
            <div class="recommended-title">
                <h2>
                    Produtos recomendados
                    <span>Selecionados para você</span>
                </h2>
            </div>

            <div class="recommended-slider-wrap">
                <div class="swiper recommended-swiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Rubber Keychain</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">
                                    <img src="{{ asset('assets/images/home/Group 21.png') }}" alt="Rubber Keychain">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Acrylic Keychain</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">
                                    <img src="{{ asset('assets/images/home/lanyard-polyester.png') }}"
                                        alt="Acrylic Keychain">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Lanyard Polyester</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/Group 971.png') }}" alt="Lanyard Polyester">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Yoyo</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">
                                    <img src="{{ asset('assets/images/home/yoyo.png') }}" alt="Yoyo">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- <div class="recommended-swiper-pagination"></div> --}}
            </div>
        </div>
    </section>
    <section class="purchase-steps-section">
        <div class="step-pattern step-pattern-left"></div>
        <div class="step-pattern step-pattern-right"></div>

        <div class="container">
            <div class="purchase-steps-title">
                <h2>Passo a Passo para Compra</h2>
            </div>

            <div class="purchase-steps-wrapper">

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">1</span>
                        <img src="{{ asset('assets/images/home/step-1.png') }}" alt="Choose and customize product">
                    </div>
                    <div class="step-text">
                        Escolha e personalize<br>
                        seu produt
                    </div>
                </div>

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">2</span>
                        <img src="{{ asset('assets/images/home/step-2.png') }}" alt="Add to cart">
                    </div>
                    <div class="step-text">
                        Adicione ao carrinho<br>
                        e revise os detalhes
                    </div>
                </div>

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">3</span>
                        <img src="{{ asset('assets/images/home/step-3.png') }}" alt="Confirm order and payment">
                    </div>
                    <div class="step-text">
                        Confirme o pedido e<br>
                        realize o pagamento
                    </div>
                </div>

                <div class="purchase-step-item">
                    <div class="step-circle">
                        <span class="step-number">4</span>
                        <img src="{{ asset('assets/images/home/step-4.png') }}" alt="Receive product">
                    </div>
                    <div class="step-text">
                        Receba seu produto<br>
                        com total segurança
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="recommended-section">


        <div class="container recommended-container">
            <div class="recommended-title">
                <h2>
                    Cordões&Accessories
                    <span>Cordões de qualidade para cada estilo.</span>
                </h2>
            </div>

            <div class="recommended-slider-wrap">
                <div class="swiper recommended-swiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Lanyard Polyester</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/acrylic-keychain.png') }}"
                                        alt="Rubber Keychain">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Lanyard Sublimation</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/Group 973.png') }}" alt="Lanyard Sublimation">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Lanyard Snap yoyo</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/image-Photoroom (39) 1.png') }}"
                                        alt="Lanyard Snap yoyo">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Yoyo</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/Group 22 (1).png') }}" alt="Yoyo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="recommended-swiper-pagination"></div> --}}
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn hero-cta">
                    <span>Ver mais</span>
                </a>
            </div>
        </div>
    </section>
    <section class="promotional-steps-section">


        <div class="container recommended-container">
            <div class="recommended-title">
                <h2>
                    Promotional good
                    <span>Brindes únicos, estilo extraordinário.</span>
                </h2>
            </div>

            <div class="recommended-slider-wrap">
                <div class="swiper recommended-swiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Rubber Keychain</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/Group 21.png') }}" alt="Rubber Keychain">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Acrylic Keychain</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/lanyard-polyester.png') }}"
                                        alt="Lanyard Sublimation">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Standee</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/Group 972.png') }}" alt="Lanyard Snap yoyo">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="recommended-card">
                                <h3>Phone Stand</h3>

                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <div class="product-img-wrap">

                                    <img src="{{ asset('assets/images/home/Group 18.png') }}" alt="Yoyo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="recommended-swiper-pagination"></div> --}}
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn hero-cta">
                    <span>Ver mais</span>
                </a>
            </div>
        </div>
    </section>
    <section class="premium-materials-section premium-materials-desktop">
        <div class="container">
            <div class="premium-materials-header">
                <h2>Seleção de Materiais Premium</h2>
                <p>
                    Explore nossa ampla variedade de materiais de alta qualidade para personalizar <br>
                    seus brindes exclusivos.
                </p>
            </div>

            <div class="materials-grid">

                <div class="material-card">
                    <div class="material-image">
                        <img src="{{ asset('assets/images/home/material-rubber-pvc.png') }}" alt="Rubber & PVC">
                    </div>
                    <div class="material-content">
                        <h3>Rubber &amp; PVC</h3>
                        <p>
                            Efeito 2D em relevo de alta qualidade, ideal para chaveiros, straps e descansos de copo.
                        </p>
                    </div>
                </div>

                <div class="material-card">
                    <div class="material-image">
                        <img src="{{ asset('assets/images/home/material-acrylic.png') }}" alt="Acrylic">
                    </div>
                    <div class="material-content">
                        <h3>Acrylic</h3>
                        <p>
                            Acrílico premium com acabamento transparente, colorido ou aurora para figuras incríveis.
                        </p>
                    </div>
                </div>

                <div class="material-card">
                    <div class="material-image">
                        <img src="{{ asset('assets/images/home/material-textile.png') }}" alt="Textile">
                    </div>
                    <div class="material-content">
                        <h3>Textile</h3>
                        <p>
                            Tecidos tecidos intrincados para amuletos tradicionais e tapeçarias de alta qualidade.
                        </p>
                    </div>
                </div>

                <div class="material-card">
                    <div class="material-image">
                        <img src="{{ asset('assets/images/home/material-polyester.png') }}" alt="Polyester">
                    </div>
                    <div class="material-content">
                        <h3>Polyester</h3>
                        <p>
                            Cordões de tecido duráveis, a escolha confiável para uso profissional diário.
                        </p>
                    </div>
                </div>

                <div class="material-card">
                    <div class="material-image">
                        <img src="{{ asset('assets/images/home/material-sublimation.png') }}" alt="Sublimation">
                    </div>
                    <div class="material-content">
                        <h3>Sublimation</h3>
                        <p>
                            Impressão digital colorida vibrante em cordões macios e de toque suave.
                        </p>
                    </div>
                </div>

                <div class="material-card">
                    <div class="material-image">
                        <img src="{{ asset('assets/images/home/material-nylon.png') }}" alt="Nylon">
                    </div>
                    <div class="material-content">
                        <h3>Nylon</h3>
                        <p>
                            Acabamento brilhante luxuoso com resistência premium e visual sofisticado.
                        </p>
                    </div>
                </div>

                <div class="material-card material-card-wide">
                    <div class="material-image">
                        <img src="{{ asset('assets/images/home/material-other.png') }}" alt="Other Materials">
                    </div>
                    <div class="material-content">
                        <h3>Other Materials</h3>
                        <p>Specialty Materials &amp; Custom Parts</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="premium-materials-section premium-materials-mobile">
        <div class="container">
            <div class="premium-materials-header">
                <h2>Seleção de Materiais Premium</h2>
                <p>
                    Explore nossa ampla variedade de materiais de alta qualidade para personalizar
                    seus brindes exclusivos.
                </p>
            </div>

            <div class="swiper premium-materials-swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-rubber-pvc.png') }}" alt="Rubber & PVC">
                            </div>
                            <div class="material-content">
                                <h3>Rubber &amp; PVC</h3>
                                <p>Efeito 2D em relevo de alta qualidade, ideal para chaveiros, straps e descansos de copo.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-acrylic.png') }}" alt="Acrylic">
                            </div>
                            <div class="material-content">
                                <h3>Acrylic</h3>
                                <p>Acrílico premium com acabamento transparente, colorido ou aurora para figuras incríveis.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-textile.png') }}" alt="Textile">
                            </div>
                            <div class="material-content">
                                <h3>Textile</h3>
                                <p>Tecidos tecidos intrincados para amuletos tradicionais e tapeçarias de alta qualidade.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-polyester.png') }}" alt="Polyester">
                            </div>
                            <div class="material-content">
                                <h3>Polyester</h3>
                                <p>Cordões de tecido duráveis, a escolha confiável para uso profissional diário.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-sublimation.png') }}" alt="Sublimation">
                            </div>
                            <div class="material-content">
                                <h3>Sublimation</h3>
                                <p>Impressão digital colorida vibrante em cordões macios e de toque suave.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-nylon.png') }}" alt="Nylon">
                            </div>
                            <div class="material-content">
                                <h3>Nylon</h3>
                                <p>Acabamento brilhante luxuoso com resistência premium e visual sofisticado.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="material-card">
                            <div class="material-image">
                                <img src="{{ asset('assets/images/home/material-other.png') }}" alt="Other Materials">
                            </div>
                            <div class="material-content">
                                <h3>Other Materials</h3>
                                <p>Specialty Materials &amp; Custom Parts</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <div class="premium-materials-pagination"></div> --}}
            </div>
        </div>
    </section>
    <section class="blog-inspirations-section">
        <div class="container">
            <div class="blog-inspirations-header">
                <h2>Blog e Inspirações</h2>
            </div>

            <div class="blog-swiper-wrap">
                <div class="swiper blog-swiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <article class="blog-card">
                                <a href="#" class="blog-image">
                                    <img src="{{ asset('assets/images/home/blog-1.png') }}" alt="Blog">
                                </a>

                                <div class="blog-content">
                                    <h3>xsqvfzsqrvf</h3>
                                    <p>
                                        khgkjflsdjv;jzkxvj jfdj aaaaa aaa aaaaaaaaaa vxvvvv zgyzf dszbvxf zgyzv gs sgxvzv
                                        vxzvd
                                    </p>

                                    <div class="blog-meta">
                                        <span class="blog-tag blog-tag-blue">Brindes</span>
                                        <span class="blog-date">24/04/2026</span>
                                    </div>
                                </div>
                            </article>
                        </div>

                        <div class="swiper-slide">
                            <article class="blog-card">
                                <a href="#" class="blog-image">
                                    <img src="{{ asset('assets/images/home/blog-2.png') }}" alt="Blog">
                                </a>

                                <div class="blog-content">
                                    <h3>zsgqvzsqzs</h3>
                                    <p>
                                        khgkjflsdjv;jzkxvj jfdj aaaaa aaa aaaaaaaaaa vxvvvv zgyzf dszbvxf
                                    </p>

                                    <div class="blog-meta">
                                        <span class="blog-tag blog-tag-yellow">Mercado</span>
                                        <span class="blog-date">24/04/2026</span>
                                    </div>
                                </div>
                            </article>
                        </div>

                        <div class="swiper-slide">
                            <article class="blog-card">
                                <a href="#" class="blog-image">
                                    <img src="{{ asset('assets/images/home/blog-3.png') }}" alt="Blog">
                                </a>

                                <div class="blog-content">
                                    <h3>gfvsdFSDF</h3>
                                    <p>
                                        khgkjflsdjv;jzkxvj jfdj aaaaa aaa aaaaaaaaaa vxvvvv zgyzf dszbvxf zgyzv gs sgxvzv
                                        vxzvd
                                    </p>

                                    <div class="blog-meta">
                                        <span class="blog-tag blog-tag-blue">Design</span>
                                        <span class="blog-date">24/04/2026</span>
                                    </div>
                                </div>
                            </article>
                        </div>

                        <div class="swiper-slide">
                            <article class="blog-card">
                                <a href="#" class="blog-image">
                                    <img src="{{ asset('assets/images/home/blog-4.png') }}" alt="Blog">
                                </a>

                                <div class="blog-content">
                                    <h3>AFAFcAZSf</h3>
                                    <p>
                                        khgkjflsdjv;jzkxvj jfdj aaaaa aaa aaaaaaaaaa vxvvvv zgyzf
                                        dszbvxf....................................
                                    </p>

                                    <div class="blog-meta">
                                        <span class="blog-tag blog-tag-blue">Design</span>
                                        <span class="blog-date">24/04/2026</span>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>
                </div>

                <div class="blog-swiper-pagination"></div>
            </div>

            <div class="blog-button-wrap">
                <a href="#" class="blog-more-btn">Explorar Mais no Blog</a>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.recommended-swiper', {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: false,
                speed: 500,

                pagination: {
                    el: '.recommended-swiper-pagination',
                    clickable: true,
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1.5,
                        spaceBetween: 16,
                    },
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.premium-materials-swiper', {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: false,
                speed: 500,

                pagination: {
                    el: '.premium-materials-swiper-pagination',
                    clickable: true,
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1.5,
                        spaceBetween: 16,
                    },
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    }
                }
            });
        });
    </script>
    {{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    let premiumMaterialsSwiper = null;

    function initPremiumMaterialsSwiper() {
        const isMobile = window.innerWidth <= 767;

        if (isMobile && premiumMaterialsSwiper === null) {
            premiumMaterialsSwiper = new Swiper('.premium-materials-swiper', {
                slidesPerView: 1.25,
                spaceBetween: 12,
                speed: 500,
                pagination: {
                    el: '.premium-materials-pagination',
                    clickable: true,
                },
                  breakpoints: {
                    0: {
                        slidesPerView: 1.5,
                        spaceBetween: 16,
                    },
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    }
                }
            });
        }

        if (!isMobile && premiumMaterialsSwiper !== null) {
            premiumMaterialsSwiper.destroy(true, true);
            premiumMaterialsSwiper = null;
        }
    }

    initPremiumMaterialsSwiper();
    window.addEventListener('resize', initPremiumMaterialsSwiper);
});
</script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let blogSwiper = null;

            function initBlogSwiper() {
                const isMobile = window.innerWidth < 768;

                if (isMobile && blogSwiper === null) {
                    blogSwiper = new Swiper('.blog-swiper', {
                        slidesPerView: 1.2,
                        spaceBetween: 14,
                        speed: 500,
                        pagination: {
                            el: '.blog-swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            0: {
                                slidesPerView: 1.5,
                                spaceBetween: 16,
                            },
                            576: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            992: {
                                slidesPerView: 3,
                                spaceBetween: 24,
                            },
                            1200: {
                                slidesPerView: 4,
                                spaceBetween: 30,
                            }
                        }
                    });
                }

                if (!isMobile && blogSwiper !== null) {
                    blogSwiper.destroy(true, true);
                    blogSwiper = null;
                }
            }

            initBlogSwiper();
            window.addEventListener('resize', initBlogSwiper);
        });
    </script>
@endsection
