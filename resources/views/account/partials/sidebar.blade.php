<aside class="account-sidebar">
    <div class="sidebar-profile">
        <div class="sidebar-avatar">
            @if(!empty($user->avatar))
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
            @else
                <div class="sidebar-avatar-placeholder">
                    {{ strtoupper(substr($user->first_name ?? $user->name ?? 'U', 0, 1)) }}
                </div>
            @endif
        </div>

        <div>
            <div class="sidebar-name">
                {{ $user->name }}
            </div>

            <a href="{{ route('account.index') }}" class="sidebar-edit">
                <img src="{{ asset('assets/images/icon/edit-icon1.png') }}" alt="">
                Edit Account
            </a>
        </div>
    </div>

    <ul class="account-menu">
        <li>
            <a href="{{ route('account.index') }}"
                class="{{ request()->routeIs('account.index') ? 'active' : '' }}">
                Contact
            </a>
        </li>

        <li>
            <a href="#">
                Addresses &rsaquo;
            </a>
        </li>

        <li>
            <a href="#">
                Order
            </a>
        </li>

        <li>
            <a href="#">
                Reward
            </a>
        </li>
    </ul>

    <div class="sign-out-box">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="sign-out-btn">
                &larr; Sign Out
            </button>
        </form>
    </div>
</aside>
