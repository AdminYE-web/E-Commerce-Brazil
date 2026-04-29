<header class="site-header">

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
                            Lanyard
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link desktop-menu-toggle" data-target="otherProductMegaMenu">
                            Other Product
                        </button>
                    </li>
                </ul>

                <!-- Search -->
                <form class="search-box" action="#" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="keyword" placeholder="SEARCH">
                </form>

                <!-- Icons -->
                <div class="header-icons">
                    <a href="#" class="icon-link">
                        <i class="bi bi-envelope"></i>
                    </a>

                    <a href="#" class="icon-link">
                        <i class="bi bi-cart"></i>
                    </a>

                    <div class="language-box">
                        <img src="{{ asset('assets/images/br-flag.png') }}" alt="BR" class="flag-img">
                        <span class="arrow-down">
                            <i class="bi bi-chevron-down"></i>
                        </span>
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
                        <div class="mega-menu-title">Printed Lanyards</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">Polyester Lanyards</a></li>
                            <li><a href="#">Nylon Lanyards</a></li>
                            <li><a href="#">PU Leather Lanyards</a></li>
                            <li><a href="#">Sublimation Lanyards</a></li>
                            <li><a href="#">Reflector Lanyards</a></li>
                            <li><a href="#">Premium Lanyards</a></li>
                            <li><a href="#">Jacquard Lanyards</a></li>
                            <li><a href="#">Yoyo Badge Lanyard</a></li>
                            <li><a href="#">Eco-Friendly Lanyards</a></li>
                            <li><a href="#">Ready-to-Use Lanyards</a></li>
                            <li><a href="#">Antibacterial Lanyards</a></li>
                        </ul>

                        <a href="#" class="mega-menu-view-all">View All <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <!-- column 2 -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">Blank Lanyards</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">Polyester Lanyards (Flag Red)</a></li>
                            <li><a href="#">Polyester Lanyards (348C)</a></li>
                            <li><a href="#">Polyester Lanyards (293C)</a></li>
                        </ul>
                    </div>

                    <!-- card 1 -->
                    <div class="mega-product-card">
                        <div class="mega-product-image">
                            <img src="{{ asset('assets/images/home/lanyard-red.png') }}"
                                alt="Polyester Lanyards (Flag Red)">
                        </div>
                        <div class="mega-product-content">
                            <h4>Polyester Lanyards (Flag Red) (10mm)</h4>
                            <p>
                                This blank employee lanyard measures 45 cm (450 mm) in length and 10 mm in width,...
                            </p>
                        </div>
                    </div>

                    <!-- card 2 -->
                    <div class="mega-product-card">
                        <div class="mega-product-image">
                            <img src="{{ asset('assets/images/home/lanyard-orange.png') }}" alt="Polyester Lanyards">
                        </div>
                        <div class="mega-product-content">
                            <h4>Polyester Lanyards</h4>
                            <p>
                                This #1 best-selling lanyard is fully customizable in size and design, with the option
                                to screen print your company name.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="desktop-mega-menu" id="otherProductMegaMenu">
            <div class="container-fluid mega-menu-container">
                <div class="mega-menu-grid other-product-grid">

                    <!-- ID Case -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">ID Case</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">Soft ID Card Holder (Horizontal) STD-1</a></li>
                            <li><a href="#">Soft ID Card Holder (Horizontal) STD-2</a></li>
                            <li><a href="#">Soft ID Card Holder (Horizontal) STD-3</a></li>
                            <li><a href="#">Soft ID Card Holder 1_N</a></li>
                            <li><a href="#">Soft ID Card Holder 2_N</a></li>
                            <li><a href="#">Soft ID Card Holder 3_N</a></li>
                            <li><a href="#">Soft ID Card Holder 4_N</a></li>
                            <li><a href="#">Soft ID Card Holder 6_N</a></li>
                            <li><a href="#">Leather Badge Holder</a></li>
                            <li><a href="#">Rigid Frame ID Card Holder F001</a></li>
                            <li><a href="#">Rigid Frame ID Card Holder F002</a></li>
                        </ul>

                        <a href="#" class="mega-menu-view-all">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Attachment -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">Attachment</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">Resin Logo Front Keeper</a></li>
                            <li><a href="#">Snap yoyo</a></li>
                            <li><a href="#">Spring Hook</a></li>
                            <li><a href="#">Oval Spring Hook</a></li>
                            <li><a href="#">Metal Clip</a></li>
                            <li><a href="#">Metal Clip with PVC Strap</a></li>
                            <li><a href="#">A-Clip</a></li>
                            <li><a href="#">PVC Hook</a></li>
                            <li><a href="#">Euro Clip A</a></li>
                            <li><a href="#">Euro Clip B</a></li>
                            <li><a href="#">Euro Clip C</a></li>
                        </ul>

                        <a href="#" class="mega-menu-view-all">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Badge Reel -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">Badge Reel</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">Black &amp; White Badge Reel</a></li>
                            <li><a href="#">Carabiner Badge Reel</a></li>
                            <li><a href="#">Stopper Badge Reel</a></li>
                        </ul>
                    </div>

                    <!-- Other -->
                    <div class="mega-menu-col">
                        <div class="mega-menu-title">Other</div>
                        <ul class="mega-menu-list">
                            <li><a href="#">Wrist Straps</a></li>
                            <li><a href="#">Phone Strap Case</a></li>
                            <li><a href="#">Carabiner</a></li>
                        </ul>
                    </div>

                    <!-- Product card -->
                    <div class="mega-product-card other-product-card">
                        <div class="mega-product-image">
                            <img src="{{ asset('assets/images/home/wrist-straps.png') }}" alt="Wrist Straps">
                        </div>

                        <div class="mega-product-content">
                            <h4>Wrist Straps</h4>
                            <p>
                                Perfect for marathons, running events, and festivals. These compact wrist straps come
                                with a
                                secure locking slider, making...
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
                <a href="#" class="icon-link">
                    <i class="bi bi-envelope"></i>
                </a>
                <a href="#" class="icon-link">
                    <i class="bi bi-cart"></i>
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="mobile-search-wrap">
            <form class="search-box mobile-search-box d-flex" action="#" method="GET">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="keyword" placeholder="Search">
            </form>
        </div>
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
                        <span>Lanyard</span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>

                <li>
                    <button type="button" class="mobile-menu-link open-submenu" data-target="otherProductMenuPanel">
                        <span>Other Product</span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>

                <li>
                    <button type="button" class="mobile-menu-link open-submenu" data-target="additionalMenuPanel">
                        <span>Additional Lanyard Details</span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>

                <li><a href="#" class="mobile-menu-link"><span>Track order</span></a></li>
                <li><a href="#" class="mobile-menu-link"><span>Gallery</span></a></li>
                <li><a href="#" class="mobile-menu-link"><span>Blog</span></a></li>
                <li><a href="#" class="mobile-menu-link"><span>FAQ</span></a></li>
                <li><a href="#" class="mobile-menu-link"><span>About Us</span></a></li>
                <li><a href="#" class="mobile-menu-link"><span>Contact Us</span></a></li>
            </ul>
        </div>


        <!-- LANYARD SUB MENU -->
        <div class="mobile-menu-panel" id="lanyardMenuPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-main-menu">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>Lanyard</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                <li><a href="#">Polyester Lanyards</a></li>
                <li><a href="#">Nylon Lanyards</a></li>
                <li><a href="#">Sublimation Lanyards</a></li>
            </ul>
        </div>


        <!-- OTHER PRODUCT SUB MENU -->
        <div class="mobile-menu-panel" id="otherProductMenuPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-main-menu">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>Other Product</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                <li><a href="#">Badge Holder</a></li>
                <li><a href="#">ID Card Holder</a></li>
                <li><a href="#">Keychain</a></li>
                <li><a href="#">Wristband</a></li>
            </ul>
        </div>


        <!-- ADDITIONAL SUB MENU -->
        <div class="mobile-menu-panel" id="additionalMenuPanel">
            <div class="submenu-title-row">
                <button type="button" class="back-main-menu">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span>Additional Lanyard Details</span>
            </div>

            <ul class="mobile-menu-list submenu-list">
                <li><a href="#">Printing Method</a></li>
                <li><a href="#">Material Guide</a></li>
                <li><a href="#">Attachment Options</a></li>
                <li><a href="#">Size Guide</a></li>
            </ul>
        </div>

    </div>
</div>
