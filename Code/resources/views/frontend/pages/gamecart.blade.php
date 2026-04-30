@extends('frontend.layouts.master')

@section('title', 'Cart Page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        @php
            $points = null;

            if (auth()->check()) {
                $points = DB::table('users')->where('id', auth()->user()->id)->pluck('points')->first();
            }
        @endphp

        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.cart') }}</span>
                        <h1 class="section-title">{{ __('common.cart') }}</h1>
                        <p class="section-copy mt-6">
                            Review your selected game services, optional training hours, and total points before completing the purchase flow.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.cart') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        @auth
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Available Points</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">{{ $points }}</p>
                            </div>
                        @endauth
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Cart Items</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ Helper::cartCount() }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.total') }} {{ __('common.points') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ number_format(Helper::totalCartPrice(), 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">Selected Services</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">Your game service cart</h2>
                </div>

                @if(Helper::cartCount())
                    <div class="mt-8 space-y-5">
                        @foreach(Helper::getAllProductFromCart()->where('order_id', null) as $key => $cart)
                            @php
                                $photo = explode(',', $cart->product['photo']);
                                $product_detail = App\Models\Product::getProductBySlug($cart->product->slug);
                                $m = Helper::getProductPriceByCurrency(session('currency'), $cart->product);
                                $a = $cart['price'] - $product_detail->price;
                                $hours = $a / 20;
                                $basic = $product_detail->price;
                                $perhour = 20;
                            @endphp

                            <article class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5 sm:p-6">
                                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex items-start gap-4">
                                        <a href="{{ route('product-detail', $cart->product->slug) }}" class="block overflow-hidden rounded-[1.5rem] border border-white/10">
                                            <img src="{{ asset($photo[0]) }}" alt="{{ $cart->product['title'] }}" class="h-24 w-24 object-cover">
                                        </a>

                                        <div class="space-y-3">
                                            <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.product') }}</p>
                                            <h3 class="text-2xl font-black tracking-tight text-on-surface">
                                                <a href="{{ route('product-detail', $cart->product->slug) }}" class="transition hover:text-primary">
                                                    {{ $cart->product['title'] }}
                                                </a>
                                            </h3>

                                            @if($hours > 0)
                                                <div class="rounded-[1.25rem] border border-primary/15 bg-primary/10 px-4 py-3">
                                                    <div class="flex flex-wrap items-center gap-3">
                                                        <p class="font-semibold text-on-surface">{{ $hours }} {{ __('common.hours') }}</p>
                                                        <a href="{{ route('trainingdelete', $cart->id) }}" class="text-sm font-semibold text-primary transition hover:text-white">
                                                            Remove Training
                                                        </a>
                                                    </div>
                                                    <p class="mt-2 text-sm text-on-surface-variant">
                                                        {{ number_format($basic, 0) }} + ( {{ $hours }} X {{ number_format($perhour, 0) }} )
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div class="rounded-[1.25rem] border border-white/10 bg-black/20 px-4 py-4">
                                            <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.points') }}</p>
                                            <p class="mt-2 text-lg font-bold text-on-surface">{{ number_format($cart['price'], 0) }}</p>
                                        </div>

                                        <div class="flex items-center">
                                            <a href="{{ route('cart-delete', $cart->id) }}" class="btn-ghost w-full justify-center">
                                                {{ __('common.remove') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-8 rounded-[1.75rem] border border-white/10 bg-black/20 px-6 py-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.total') }} {{ __('common.points') }}</p>
                            <p class="text-3xl font-black text-on-surface">{{ number_format(Helper::totalCartPrice(), 0) }}</p>
                        </div>
                    </div>
                @else
                    <div class="mt-8 rounded-[2rem] border border-dashed border-white/15 bg-white/5 px-6 py-12 text-center">
                        <p class="font-headline text-sm uppercase tracking-[0.22em] text-primary">Cart Empty</p>
                        <h3 class="mt-4 text-2xl font-black text-on-surface">{{ __('common.no_cart_available') }}</h3>
                        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                            There are no active game services in this cart right now.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="btn-primary">
                                {{ __('common.continue_shopping') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <aside class="space-y-6">
                <div class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">Purchase Summary</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface">Points total</h2>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center justify-between rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-4">
                            <span class="text-sm uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.total') }}</span>
                            <span class="text-xl font-black text-on-surface">{{ number_format(Helper::totalCartPrice(), 0) }}</span>
                        </div>

                        @auth
                            <div class="flex items-center justify-between rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-4">
                                <span class="text-sm uppercase tracking-[0.18em] text-on-surface-variant">Available Points</span>
                                <span class="text-xl font-black text-on-surface">{{ $points }}</span>
                            </div>
                        @endauth
                    </div>

                    @if(Helper::cartCount())
                        <div class="mt-8">
                            <a href="{{ route('buygame') }}" class="btn-primary w-full justify-center">
                                {{ __('common.purchase_services') }}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="glass-panel p-6">
                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Purchase Note</p>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">
                        Training-hour removal, service removal, total points, and final purchase all continue through the existing backend routes.
                    </p>
                </div>
            </aside>
        </section>
    </main>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
