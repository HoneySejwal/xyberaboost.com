@extends('frontend.layouts.master')

@section('title', 'Cart Page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-surface/85 shadow-soft">
                <div class="hero-orb left-[-5rem] top-[-4rem] h-48 w-48 bg-primary/20"></div>
                <div class="hero-orb bottom-[-5rem] right-[-3rem] h-60 w-60 bg-secondary/20"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,120,42,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(255,196,120,0.12),transparent_28%)]"></div>

                <div class="relative z-10 grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1.08fr_0.92fr] lg:px-12 lg:py-12">
                    <div class="flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-primary">
                                <span class="h-2 w-2 rounded-full bg-primary shadow-[0_0_18px_rgba(255,120,42,0.9)]"></span>
                                {{ __('common.cart_stage_label') }}
                            </div>

                            <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-[-0.04em] text-on-surface sm:text-5xl lg:text-6xl">
                                {{ __('common.cart_title') }}
                            </h1>
                            <p class="mt-5 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                                {{ __('common.cart_intro') }}
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

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.cart_metric_items_label') }}</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">{{ Helper::cartCount() }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.total') }}</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">
                                    {{ Helper::getCurrencySymbol(session('currency')) }}
                                    {{ number_format(Helper::totalCartPrice(), session('currency') == 'JPY' ? 0 : 2) }}
                                </p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.cart_metric_flow_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.cart_metric_flow_value') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/30 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.cart_summary_label') }}</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">{{ __('common.cart_summary_title') }}</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            {{ __('common.cart_summary_text') }}
                        </p>

                        <div class="mt-6 space-y-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.cart_metric_items_label') }}</span>
                                    <span class="text-lg font-black text-on-surface">{{ Helper::cartCount() }}</span>
                                </div>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.total') }}</span>
                                    <span class="text-lg font-black text-on-surface">
                                        {{ Helper::getCurrencySymbol(session('currency')) }}
                                        {{ number_format(Helper::totalCartPrice(), session('currency') == 'JPY' ? 0 : 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('checkout') }}" class="btn-primary w-full justify-center">
                                {{ __('common.checkout') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">{{ __('common.cart_selected_label') }}</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.cart_selected_title') }}</h2>
                </div>

                @if(Helper::cartCount())
                    <div class="mt-8 space-y-5">
                        @foreach(Helper::getAllProductFromCart() as $key => $cart)
                            @php
                                $user_id = auth()->check() ? auth()->id() : session('guest');
                                $points = App\Models\Cart::where('user_id', $user_id)->where('order_id', null)->pluck('points')->first();
                            @endphp

                            <article class="rounded-[1.9rem] border border-white/10 bg-white/5 p-5 sm:p-6">
                                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                                    <div class="space-y-3">
                                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.product') }}</p>
                                        <h3 class="text-2xl font-black tracking-tight text-on-surface">
                                            {{ $points . ' ' . __('common.points') }}
                                        </h3>
                                        <p class="max-w-xl text-sm leading-7 text-on-surface-variant">
                                            {{ __('common.cart_item_text') }}
                                        </p>
                                    </div>

                                    <div class="grid gap-4 sm:grid-cols-2 xl:min-w-[420px] xl:grid-cols-[1fr_1fr_auto]">
                                        <div class="rounded-[1.25rem] border border-white/10 bg-black/20 px-4 py-4">
                                            <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.price') }}</p>
                                            <p class="mt-2 text-lg font-bold text-on-surface">
                                                {{ Helper::getCurrencySymbol(session('currency')) }}
                                                {{ number_format($cart['price'], session('currency') == 'JPY' ? 0 : 2) }}
                                            </p>
                                        </div>

                                        <div class="rounded-[1.25rem] border border-white/10 bg-black/20 px-4 py-4">
                                            <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.total') }}</p>
                                            <p class="mt-2 text-lg font-bold text-on-surface">
                                                {{ Helper::getCurrencySymbol(session('currency')) }}
                                                {{ number_format($cart['amount'], session('currency') == 'JPY' ? 0 : 2) }}
                                            </p>
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
                @else
                    <div class="mt-8 rounded-[2rem] border border-dashed border-white/15 bg-white/5 px-6 py-12 text-center">
                        <p class="font-headline text-sm uppercase tracking-[0.22em] text-primary">{{ __('common.cart_empty_label') }}</p>
                        <h3 class="mt-4 text-2xl font-black text-on-surface">{{ __('common.no_cart_available') }}</h3>
                        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                            {{ __('common.cart_empty_text') }}
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
                        <span class="section-label">{{ __('common.cart_summary_label') }}</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface">{{ __('common.cart_summary_title') }}</h2>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center justify-between rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-4">
                            <span class="text-sm uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.total') }}</span>
                            <span class="text-xl font-black text-on-surface">
                                {{ Helper::getCurrencySymbol(session('currency')) }}
                                {{ number_format(Helper::totalCartPrice(), session('currency') == 'JPY' ? 0 : 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('checkout') }}" class="btn-primary w-full justify-center">
                            {{ __('common.checkout') }}
                        </a>
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.cart_note_label') }}</p>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">
                        {{ __('common.cart_note_text') }}
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
