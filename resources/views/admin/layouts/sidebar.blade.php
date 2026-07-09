<aside class="sidebar">
    <div class="sidebar-header">
        <div class="brand-name">Admin</div>
        <div class="brand-subtitle">Product Management</div>
    </div>

    {{-- <a href="{{ route('admin.products.create') }}" class="add-btn">
        + Add New Product
    </a> --}}
    @php
    $adminUser = auth('admin')->user();
    $isNormalAdmin = $adminUser && $adminUser->role === 'admin';
@endphp

    <ul class="nav-list">
        {{-- <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li> --}}

        @php
            $productMenuActive = request()->routeIs(
                'admin.product-list-banners.*',
                'admin.categories.*',
                'admin.materials.*',
                'admin.products.*',
                'admin.product-details.*',
                'admin.product-price-tiers.*',
                'admin.option-groups.*',
                'admin.product-options.*',
                'admin.product-option-variants.*',
                'admin.option-dependencies.*',
                'admin.product-price-rules.*',
                'admin.product-artwork-templates.*',
                'admin.product-templates.*',
            );
        @endphp

        <li class="nav-item has-dropdown {{ $productMenuActive ? 'open' : '' }}">
            <button type="button" class="nav-link dropdown-toggle {{ $productMenuActive ? 'active' : '' }}"
                onclick="this.closest('.has-dropdown').classList.toggle('open')">
                <span>Products</span>
                <span class="dropdown-arrow">▾</span>
            </button>

            <ul class="sub-nav">
                <li>
                    <a href="{{ route('admin.product-list-banners.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-list-banners.*') ? 'active' : '' }}">
                        Product List Banners
                    </a>
                </li>
                <li><a href="{{ route('admin.categories.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>
                </li>
                <li><a href="{{ route('admin.materials.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}">Materials</a>
                </li>
                <li><a href="{{ route('admin.products.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Products</a>
                </li>
                <li><a href="{{ route('admin.product-price-rules.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-price-rules.*') ? 'active' : '' }}">Product
                        Price Rules</a></li>
                <li><a href="{{ route('admin.option-price-rules.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.option-price-rules.*') ? 'active' : '' }}">Option
                        Price Rules</a></li>
                        
                <li><a href="{{ route('admin.option-groups.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.option-groups.*') ? 'active' : '' }}">Option
                        Groups</a></li>
                <li><a href="{{ route('admin.product-options.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-options.*', 'admin.product-option-variants.*') ? 'active' : '' }}">Product
                        Options</a></li>
                <li><a href="{{ route('admin.option-dependencies.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.option-dependencies.*') ? 'active' : '' }}">Option
                        Dependencies</a></li>
                <li><a href="{{ route('admin.product-artwork-templates.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-artwork-templates.*') ? 'active' : '' }}">Product
                        Artwork Templates</a></li>
                <li>
                    <a href="{{ route('admin.product-templates.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-templates.*') ? 'active' : '' }}">
                        Product Templates
                    </a>
                </li>

            </ul>
        </li>
        
 <li class="nav-item">
            <a href="{{ route('admin.menu-products.index') }}"
                class="nav-link {{ request()->routeIs('admin.menu-products.*') ? 'active' : '' }}">
                Menu Bar & <br>
                 Recommended Products
            </a>
        </li>


        @php
            $homepageMenuActive = request()->routeIs('admin.home-banners.*', 'admin.material-homes.*');
        @endphp

        <li class="nav-item has-dropdown {{ $homepageMenuActive ? 'open' : '' }}">
            <button type="button" class="nav-link dropdown-toggle {{ $homepageMenuActive ? 'active' : '' }}"
                onclick="this.closest('.has-dropdown').classList.toggle('open')">
                <span>Homepage</span>
                <span class="dropdown-arrow">▾</span>
            </button>

            <ul class="sub-nav">

                <li>
                    <a href="{{ route('admin.home-banners.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.home-banners.*') ? 'active' : '' }}">
                        Home Banners
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.material-homes.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.material-homes.*') ? 'active' : '' }}">
                        Material Homes
                    </a>
                </li>

            </ul>
        </li>
        @php
            $galleryMenuActive = request()->routeIs('admin.galleries.*', 'admin.gallery-banners.*');
        @endphp
        <li class="nav-item has-dropdown {{ $galleryMenuActive ? 'open' : '' }}">
            <button type="button" class="nav-link dropdown-toggle {{ $galleryMenuActive ? 'active' : '' }}"
                onclick="this.closest('.has-dropdown').classList.toggle('open')">
                <span>Galleries</span>
                <span class="dropdown-arrow">▾</span>
            </button>

            <ul class="sub-nav">
                <li>
                    <a href="{{ route('admin.gallery-banners.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.gallery-banners.*') ? 'active' : '' }}">
                        Gallery Banners
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.galleries.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                        Galleries
                    </a>
                </li>

            </ul>
        </li>
        @php
            $articleMenuActive = request()->routeIs('admin.articles.*', 'admin.article-banners.*');
        @endphp
        <li class="nav-item has-dropdown {{ $articleMenuActive ? 'open' : '' }}">
            <button type="button" class="nav-link dropdown-toggle {{ $articleMenuActive ? 'active' : '' }}"
                onclick="this.closest('.has-dropdown').classList.toggle('open')">
                <span>Articles</span>
                <span class="dropdown-arrow">▾</span>
            </button>

            <ul class="sub-nav">
                <li>
                    <a href="{{ route('admin.articles.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                        Articles
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('admin.article-banners.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.article-banners.*') ? 'active' : '' }}">
                        Article Banners
                    </a>
                </li> --}}
            </ul>
        </li>
      @if(!$isNormalAdmin)
    @php
        $systemMenuActive = request()->routeIs('admin.system-management.*');
    @endphp

    <li class="nav-item has-dropdown {{ $systemMenuActive ? 'open' : '' }}">
        <button type="button" class="nav-link dropdown-toggle {{ $systemMenuActive ? 'active' : '' }}"
            onclick="this.closest('.has-dropdown').classList.toggle('open')">
            <span>System</span>
            <span class="dropdown-arrow">▾</span>
        </button>

        <ul class="sub-nav">
            <li>
                <a href="{{ route('admin.system-management.index') }}"
                    class="sub-nav-link {{ request()->routeIs('admin.system-management.*') ? 'active' : '' }}">
                    System Management
                </a>
            </li>
        </ul>
    </li>
@endif
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}"
                class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                Orders
            </a>
        </li>
        <li>
            <a href="{{ route('admin.quotations.index') }}"
                class="nav-link {{ request()->routeIs('admin.quotations.*') ? 'active' : '' }}">
                Quotations
            </a>
        </li>

      @if(!$isNormalAdmin)
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}"
            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            Users
        </a>
    </li>
@endif
        <li class="nav-item">
            <a href="{{ route('admin.contact-submissions.index') }}"
                class="nav-link {{ request()->routeIs('admin.contact-submissions.*') ? 'active' : '' }}">
                Contact List
            </a>
        </li>

        <li>
            <a href="{{ route('admin.faqs.index') }}"
                class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                FAQs
            </a>
        </li>

    </ul>

    <div class="sidebar-footer">
        <a href="#" class="nav-link">Help Center</a>

        <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
            @csrf

            <button type="submit" class="nav-link logout-btn">
                Logout
            </button>
        </form>
    </div>
</aside>


<a href="{{ route('admin.orders.index') }}"
    class="sub-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
    Orders
</a>
