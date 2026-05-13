<aside class="sidebar">
    <div class="sidebar-header">
        <div class="brand-name">Indigo Admin</div>
        <div class="brand-subtitle">Product Management</div>
    </div>

    {{-- <a href="{{ route('admin.products.create') }}" class="add-btn">
        + Add New Product
    </a> --}}

    <ul class="nav-list">
        {{-- <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li> --}}

        <li class="nav-item">
            <a href="{{ route('admin.products.index') }}"
                class="nav-link {{ request()->routeIs(
                    'admin.products.*',
                    'admin.product-details.*',
                    'admin.product-price-tiers.*',
                    'admin.option-groups.*',
                    'admin.product-options.*',
                    'admin.option-dependencies.*',
                    'admin.product-list-banners.*',
                    'admin.product-price-rules.*',
                    'admin.product-artwork-templates.*',
                )
                    ? 'active'
                    : '' }}">
                Products
            </a>

            <ul class="sub-nav">
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        Categories
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.materials.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}">
                        Materials
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        Products
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('admin.product-details.index') }}"
                       class="sub-nav-link {{ request()->routeIs('admin.product-details.*') ? 'active' : '' }}">
                        Product Details
                    </a>
                </li> --}}

                <li>
                    <a href="{{ route('admin.product-price-rules.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-price-rules.*') ? 'active' : '' }}">
                        Product Price Rules
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.option-groups.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.option-groups.*') ? 'active' : '' }}">
                        Option Groups
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.product-options.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-options.*', 'admin.product-option-variants.*') ? 'active' : '' }}">
                        Product Options
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.option-dependencies.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.option-dependencies.*') ? 'active' : '' }}">
                        Option Dependencies
                    </a>
                </li>

                
                <li>
                    <a href="{{ route('admin.product-artwork-templates.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-artwork-templates.*') ? 'active' : '' }}">
                        Product Artwork Templates
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.product-list-banners.index') }}"
                        class="sub-nav-link {{ request()->routeIs('admin.product-list-banners.*') ? 'active' : '' }}">
                        Product List Banners
                    </a>
                </li>

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
