@php
    $categories = Helper::productCategoryList("all");
    $currency = session('currency', 'USD');
    $currencyLabel = $currency === 'JPY' ? 'JPY' : ($currency === 'HKD' ? 'HKD' : 'USD');
    $localeLabel = session('app_locale') === 'ja' ? __('common.japanese') : __('common.english');
    $userPoints = auth()->check()
        ? DB::table('users')->where('id', auth()->id())->value('points')
        : null;
@endphp

<header x-data="{ mobileNavOpen: false, cartOpen: false }" class="site-header">
    <div class="header-main-shell">
        <div class="page-container">
            <div class="header-main-row">
                <a href="{{ route('home') }}" class="brand-lockup">
                    <img src="{{ asset('images/Logo.png') }}" alt="XyberaBoost logo" class="brand-mark">
                    <div>
                        <p class="brand-name">XyberaBoost</p>
                        <p class="brand-tagline">{{ __('common.trusted_by_gamers') }}</p>
                    </div>
                </a>

                <nav class="desktop-nav">
                    <a href="{{ route('home') }}">{{ __('common.home') }}</a>
                    <a href="{{ route('pages', 'about-us') }}">{{ __('common.about') }}</a>
                    <a href="{{ route('product-lists') }}">{{ __('common.our_games') }}</a>
                    <a href="{{ route('contact') }}">{{ __('common.contact') }}</a>
                    <a href="{{ route('pages', 'terms-conditions') }}">{{ __('common.terms_policy') }}</a>
                </nav>

                <div class="desktop-actions">
                    <div class="header-select-group">
                        <a href="{{ route('change.currency', 'USD') }}" class="{{ $currency === 'USD' ? 'active' : '' }}">USD</a>
                        <a href="{{ route('change.currency', 'JPY') }}" class="{{ $currency === 'JPY' ? 'active' : '' }}">JPY</a>
                        <a href="{{ route('change.currency', 'HKD') }}" class="{{ $currency === 'HKD' ? 'active' : '' }}">HKD</a>
                    </div>

                    <div class="header-select-group">
                        <a href="{{ route('change.language', 'en') }}" class="{{ session('app_locale') !== 'ja' ? 'active' : '' }}">{{ __('common.english') }}</a>
                        <a href="{{ route('change.language', 'ja') }}" class="{{ session('app_locale') === 'ja' ? 'active' : '' }}">{{ __('common.japanese') }}</a>
                    </div>

                    @auth
                        <a href="{{ route('user') }}" class="hud-btn hud-btn-secondary header-account-link">{{ __('common.my_account') }}</a>
                        <div class="header-points-box">{{ __('common.points') }} {{ (int) $userPoints }}</div>
                    @else
                        <a href="{{ route('login.form') }}" class="hud-btn hud-btn-secondary header-account-link">{{ __('common.log_in') }}</a>
                        <a href="{{ route('register.form') }}" class="hud-btn hud-btn-primary header-account-link">{{ __('common.sign_up') }}</a>
                    @endauth

                    <button type="button" @click="cartOpen = true" class="header-cart-button">
                        <span class="header-cart-label">{{ __('common.shopping_cart') }}</span>
                        <span class="header-cart-count">{{ Helper::getAllProductFromCart() ? Helper::totalCartQuantity() : 0 }}</span>
                    </button>
                </div>

                <div class="mobile-header-actions">
                    <button type="button" @click="cartOpen = true" class="header-cart-button">
                        <span class="header-cart-label">{{ __('common.shopping_cart') }}</span>
                        <span class="header-cart-count">{{ Helper::getAllProductFromCart() ? Helper::totalCartQuantity() : 0 }}</span>
                    </button>
                    <button type="button" @click="mobileNavOpen = true" class="header-mobile-toggle">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="mobileNavOpen" x-cloak class="fixed inset-0 z-[60] bg-black/70 backdrop-blur-sm" @click="mobileNavOpen = false"></div>
    <div x-show="mobileNavOpen" x-cloak class="mobile-nav-drawer" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
        <div class="mobile-nav-head">
            <img src="{{ asset('images/Logo.png') }}" alt="XyberaBoost logo" class="h-12 w-auto">
            <button type="button" @click="mobileNavOpen = false" class="header-mobile-toggle">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="mobile-nav-links">
            <a href="{{ route('home') }}">{{ __('common.home') }}</a>
            <a href="{{ route('pages', 'about-us') }}">{{ __('common.about') }}</a>
            <a href="{{ route('product-lists') }}">{{ __('common.our_games') }}</a>
            <a href="{{ route('contact') }}">{{ __('common.contact') }}</a>
            <a href="{{ route('pages', 'terms-conditions') }}">{{ __('common.terms_policy') }}</a>
            @auth
                <a href="{{ route('user') }}">{{ __('common.my_account') }}</a>
                <a href="{{ route('user.logout') }}">{{ __('common.logout') }}</a>
            @else
                <a href="{{ route('login.form') }}">{{ __('common.log_in') }}</a>
                <a href="{{ route('register.form') }}">{{ __('common.sign_up') }}</a>
            @endauth
        </div>

        <div class="mobile-nav-panels">
            <div class="mobile-nav-panel">
                <p>{{ __('common.stitch_status_currency') }}</p>
                <div class="mobile-nav-inline-links">
                    <a href="{{ route('change.currency', 'USD') }}">USD</a>
                    <a href="{{ route('change.currency', 'JPY') }}">JPY</a>
                    <a href="{{ route('change.currency', 'HKD') }}">HKD</a>
                </div>
            </div>

            <div class="mobile-nav-panel">
                <p>{{ __('common.stitch_status_locale') }}</p>
                <div class="mobile-nav-inline-links">
                    <a href="{{ route('change.language', 'en') }}">{{ __('common.english') }}</a>
                    <a href="{{ route('change.language', 'ja') }}">{{ __('common.japanese') }}</a>
                </div>
            </div>

            <div class="mobile-nav-panel">
                <p>{{ __('common.our_games') }}</p>
                <div class="mobile-nav-list">
                    @foreach($categories->take(8) as $cat_info)
                        <a href="{{ route('product-cat', $cat_info->slug) }}">{{ $cat_info->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div x-show="cartOpen" x-cloak class="fixed inset-0 z-[60] bg-black/70 backdrop-blur-sm" @click="cartOpen = false"></div>
    <aside x-show="cartOpen" x-cloak class="cart-drawer" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
        <div class="cart-drawer-head">
            <h3>{{ __('common.shopping_cart') }}</h3>
            <button type="button" @click="cartOpen = false" class="header-mobile-toggle">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        @if(Helper::cartCount())
            <div class="cart-drawer-items">
                @foreach(Helper::getAllProductFromCart() as $cart)
                    @if(isset($cart->product['id']) && $cart->product['id'] < 1000)
                        @php
                            $perhour = 20;
                            $hours = $cart->hours;
                        @endphp
                        <div class="cart-drawer-card">
                            <div>
                                <a href="{{ route('product-detail', $cart->product->slug) }}" class="cart-drawer-title">{{ $cart->product['title'] }}</a>
                                <p class="cart-drawer-price">{{ number_format($cart['price'], 0) }} {{ __('common.points') }}</p>
                                @if($hours > 0)
                                    <div class="cart-drawer-meta">
                                        <span>{{ $hours }} {{ __('common.hours') }}</span>
                                        <span>({{ $hours }} x {{ number_format($perhour, 0) }})</span>
                                        <a href="{{ route('trainingdelete', $cart->id) }}">Remove</a>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('cart-delete', $cart->id) }}" class="cart-drawer-delete">
                                <span class="material-symbols-outlined">delete</span>
                            </a>
                        </div>
                    @else
                        @php
                            $user_id = auth()->check() ? auth()->id() : session('guest');
                            $points = App\Models\Cart::where('user_id', $user_id)->where('order_id', null)->pluck('points')->first();
                        @endphp
                        <div class="cart-drawer-card">
                            <div>
                                <p class="cart-drawer-title">{{ $points . ' ' . __('common.points') }}</p>
                                <p class="cart-drawer-price">{{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($cart['price'], session('currency') == 'JPY' ? 0 : 2) }}</p>
                            </div>
                            <a href="{{ route('cart-delete', $cart->id) }}" class="cart-drawer-delete">
                                <span class="material-symbols-outlined">close</span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            @php
                $total_amount = Helper::totalCartPrice();
                $hasGameProducts = collect(Helper::getAllProductFromCart())->contains(function ($cartItem) {
                    return isset($cartItem->product['id']) && $cartItem->product['id'] < 1000;
                });
            @endphp

            <div class="cart-drawer-summary">
                <div class="cart-drawer-total">
                    <span>{{ __('common.total') }}</span>
                    <strong>
                        @if($hasGameProducts)
                            {{ number_format($total_amount, 0) }} {{ __('common.points') }}
                        @else
                            {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($total_amount, session('currency') == 'JPY' ? 0 : 2) }}
                        @endif
                    </strong>
                </div>
                <div class="cart-drawer-actions">
                    @if($hasGameProducts)
                        <a href="{{ route('gamecart') }}" class="hud-btn hud-btn-primary w-full text-center">{{ __('common.purchase_services') }}</a>
                    @else
                        <a href="{{ route('cart') }}" class="hud-btn hud-btn-secondary w-full text-center">{{ __('common.view_cart') }}</a>
                        <a href="{{ route('checkout') }}" class="hud-btn hud-btn-primary w-full text-center">{{ __('common.checkout') }}</a>
                    @endif
                </div>
            </div>
        @else
            <div class="cart-empty-state">{{ __('common.no_cart_available') }}</div>
        @endif
    </aside>
</header>
