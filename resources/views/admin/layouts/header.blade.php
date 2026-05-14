@php
    $adminUser = auth('admin')->user();
@endphp

<header class="header">
    {{-- <form class="search-bar" method="GET">
        <input type="text" name="search" placeholder="Search products, orders, or categories..."
               value="{{ request('search') }}">
    </form> --}}

    <div class="header-actions">
        <div class="user-profile">
            <img src="https://i.pravatar.cc/150?u={{ $adminUser->email ?? 'admin' }}" 
                 alt="{{ $adminUser->name ?? 'Admin User' }}" 
                 class="avatar">

            <div class="user-info">
                <span class="user-name">
                    {{ $adminUser->name ?? 'Admin User' }}
                </span>

                <span class="user-role">
                    {{ $adminUser->role ?? 'Super Admin' }}
                </span>
            </div>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="nav-link logout-btn">
                Logout
            </button>
        </form>
    </div>
</header>