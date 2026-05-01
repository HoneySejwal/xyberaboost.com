<aside class="dashboard-sidebar" x-show="sidebarOpen || window.innerWidth > 1100" x-transition>
    <div class="dashboard-sidebar-inner">
        <a class="dashboard-brand" href="{{ route('user') }}">
            <img src="{{ asset('images/Logo.png') }}" alt="XyberaBoost">
            <div>
                <div class="dashboard-small-label">XB</div>
                <div class="dashboard-brand-title">Player Dashboard</div>
            </div>
        </a>

        <div>
            <div class="dashboard-small-label">{{ __('common.dashboard_label') }}</div>
            <div class="dashboard-nav">
                <a class="dashboard-nav-link {{ request()->routeIs('user') ? 'active' : '' }}" href="{{ route('user') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>{{ __('common.dashboard_label') }}</span>
                </a>
                <a class="dashboard-nav-link {{ request()->routeIs('user.order.index') ? 'active' : '' }}" href="{{ route('user.order.index') }}">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span>{{ __('common.orders') }}</span>
                </a>
                <a class="dashboard-nav-link {{ request()->routeIs('user.change.password.form') ? 'active' : '' }}" href="{{ route('user.change.password.form') }}">
                    <span class="material-symbols-outlined">lock_reset</span>
                    <span>{{ __('common.change_password') }}</span>
                </a>
                <a class="dashboard-nav-link {{ request()->routeIs('user-profile') ? 'active' : '' }}" href="{{ route('user-profile') }}">
                    <span class="material-symbols-outlined">person</span>
                    <span>{{ __('common.profile_label') }}</span>
                </a>
            </div>
        </div>

        <div class="dashboard-card" style="border-radius: 1.35rem; padding: 1rem;">
            <div class="dashboard-small-label">{{ __('common.dashboard_support_label') }}</div>
            <p style="margin: 0.75rem 0 0; color: rgba(226,232,240,0.82); line-height: 1.7;">
                {{ __('common.dashboard_support_text') }}
            </p>
        </div>
    </div>
</aside>
