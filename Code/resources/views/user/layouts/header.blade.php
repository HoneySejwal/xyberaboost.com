<nav class="dashboard-topbar">
    <div class="dashboard-topbar-actions">
        <button type="button" class="dashboard-pill dashboard-mobile-toggle" @click="sidebarOpen = !sidebarOpen">
            <span class="material-symbols-outlined">menu</span>
            <span>{{ __('common.menu') ?? 'Menu' }}</span>
        </button>
        <a class="dashboard-pill" href="{{ route('home') }}" target="_blank">
            <span class="material-symbols-outlined">home</span>
            <span>{{ __('common.home') }}</span>
        </a>
        <a class="dashboard-pill" href="{{ route('user') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span>{{ __('common.dashboard_label') }}</span>
        </a>
    </div>

    <div class="dashboard-user">
        @if(Auth()->user()->photo)
            <img class="dashboard-avatar" src="{{ Auth()->user()->photo }}" alt="{{ Auth()->user()->name }}">
        @else
            <img class="dashboard-avatar" src="{{ asset('backend/img/avatar.png') }}" alt="{{ Auth()->user()->name }}">
        @endif
        <div>
            <div class="dashboard-small-label">{{ __('common.account_label') }}</div>
            <div class="dashboard-heading">{{ Auth()->user()->name }}</div>
        </div>
        <a class="dashboard-pill" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-symbols-outlined">logout</span>
            <span>{{ __('common.logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
