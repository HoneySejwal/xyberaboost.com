@extends('frontend.layouts.master')

@section('title', 'Category List')

@section('main-content')
    @php
        $products = $products ?? collect();
        $routeSlug = Request::route('slug');
        $filteredCategories = collect();

        if ($routeSlug === 'PC') {
            $catname = 2;
            $filteredCategories = Helper::productCategoryList('All')->where('catgenres', $catname)->sortBy('id');
        } elseif ($routeSlug === 'Android') {
            $catname = 1;
            $filteredCategories = Helper::productCategoryList('All')->where('catgenres', $catname)->sortBy('id');
        }
    @endphp

    <main class="pb-24 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="hud-shell storefront-hero-frame overflow-hidden px-6 py-8 sm:px-8 lg:px-10 lg:py-10">
                <div class="hud-grid-lines"></div>

                <div class="relative z-10 grid gap-8 xl:grid-cols-[minmax(0,1.1fr)_380px]">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-3 border border-primary/25 bg-primary/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.28em] text-primary">
                            <span class="h-2 w-2 rounded-full bg-primary shadow-[0_0_18px_rgba(249,115,22,0.85)]"></span>
                            {{ __('common.stitch_platform_chip') }}
                        </div>

                        <div class="storefront-panel p-6 sm:p-8">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_platform_kicker') }}</p>
                            <h1 class="mt-4 text-4xl font-black uppercase tracking-[-0.04em] text-white sm:text-5xl lg:text-6xl">{{ $routeSlug }}</h1>
                            <p class="mt-5 max-w-3xl text-sm leading-8 text-white/72 sm:text-base">
                                {{ __('common.stitch_platform_text', ['platform' => $routeSlug]) }}
                            </p>

                            <div class="mt-6 flex flex-wrap items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/55">
                                <a href="{{ route('home') }}" class="border border-white/10 bg-white/5 px-3 py-2 text-white transition hover:border-primary/40 hover:text-primary">
                                    {{ __('common.home') }}
                                </a>
                                <span>/</span>
                                <span class="border border-primary/20 bg-primary/10 px-3 py-2 text-primary">{{ $routeSlug }}</span>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="storefront-metric-card">
                                <p>{{ __('common.stitch_platform_metric_route') }}</p>
                                <strong>{{ $routeSlug }}</strong>
                                <span>{{ __('common.stitch_platform_metric_route_value') }}</span>
                            </div>
                            <div class="storefront-metric-card">
                                <p>{{ __('common.stitch_platform_metric_categories') }}</p>
                                <strong>{{ $filteredCategories->count() }}</strong>
                                <span>{{ __('common.stitch_platform_metric_categories_value') }}</span>
                            </div>
                            <div class="storefront-metric-card">
                                <p>{{ __('common.stitch_platform_metric_status') }}</p>
                                <strong>{{ __('common.stitch_platform_metric_status_value') }}</strong>
                                <span>{{ __('common.stitch_platform_metric_status_note') }}</span>
                            </div>
                        </div>
                    </div>

                    <aside class="space-y-4">
                        <div class="storefront-panel p-5 sm:p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_platform_briefing_label') }}</p>
                            <h2 class="mt-3 text-2xl font-black uppercase tracking-[-0.04em] text-white">{{ __('common.stitch_platform_briefing_title') }}</h2>
                            <p class="mt-3 text-sm leading-7 text-white/72">{{ __('common.stitch_platform_briefing_text') }}</p>
                        </div>
                        <div class="storefront-panel p-5 sm:p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_platform_signal_label') }}</p>
                            <div class="mt-4 space-y-3 text-sm text-white/70">
                                <div class="flex items-center justify-between border border-white/10 bg-white/5 px-4 py-3">
                                    <span>{{ __('common.stitch_platform_signal_route') }}</span>
                                    <strong class="text-white">{{ $routeSlug }}</strong>
                                </div>
                                <div class="flex items-center justify-between border border-white/10 bg-white/5 px-4 py-3">
                                    <span>{{ __('common.stitch_platform_signal_count') }}</span>
                                    <strong class="text-white">{{ $filteredCategories->count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 sm:mt-10">
            <div class="hud-shell overflow-hidden px-6 py-8 sm:px-8 lg:px-10">
                <div class="hud-grid-lines"></div>

                <div class="relative z-10 flex flex-col gap-5 border-b border-white/10 pb-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_platform_grid_label') }}</p>
                        <h2 class="mt-3 text-3xl font-black uppercase tracking-[-0.04em] text-white sm:text-4xl">{{ __('common.stitch_platform_grid_title') }}</h2>
                    </div>
                    <p class="max-w-2xl text-sm leading-7 text-white/66 sm:text-base">{{ __('common.stitch_platform_grid_text') }}</p>
                </div>

                @if($filteredCategories->count())
                    <div class="relative z-10 mt-8 grid gap-6 md:grid-cols-2 2xl:grid-cols-3">
                        @foreach($filteredCategories as $cat_info)
                            @php
                                $catTitle = app()->getLocale() === 'ja'
                                    ? ($cat_info->title_jp ?? $cat_info->title)
                                    : $cat_info->title;
                                $catSummary = app()->getLocale() === 'ja'
                                    ? ($cat_info->summary_jp ?? $cat_info->summary ?? '')
                                    : ($cat_info->summary ?? '');
                            @endphp

                            <article class="storefront-product-card">
                                <a href="{{ route('product-cat', $cat_info->slug) }}" class="storefront-product-thumb">
                                    <img
                                        src="{{ asset(ltrim($cat_info->photo, '/')) }}"
                                        alt="{{ $catTitle }}"
                                        class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                    >
                                </a>

                                <div class="flex flex-1 flex-col p-5 sm:p-6">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/80">{{ $routeSlug }} {{ __('common.stitch_platform_card_label') }}</p>
                                            <h3 class="mt-3 text-2xl font-black uppercase tracking-[-0.04em] text-white">
                                                <a href="{{ route('product-cat', $cat_info->slug) }}" class="transition hover:text-primary">
                                                    {{ $catTitle }}
                                                </a>
                                            </h3>
                                        </div>
                                        <span class="border border-primary/20 bg-primary/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-primary">
                                            {{ __('common.stitch_platform_live_label') }}
                                        </span>
                                    </div>

                                    <p class="mt-4 flex-1 text-sm leading-7 text-white/68">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($catSummary), 150) ?: __('common.stitch_platform_card_fallback') }}
                                    </p>

                                    <div class="mt-6 border-t border-white/10 pt-5">
                                        <a href="{{ route('product-cat', $cat_info->slug) }}" class="btn-primary w-full text-center">
                                            {{ __('common.stitch_platform_button') }}
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="relative z-10 mt-8 storefront-empty-state">
                        <p>{{ __('common.stitch_platform_empty_label') }}</p>
                        <h3>{{ __('common.stitch_platform_empty_title') }}</h3>
                        <span>{{ __('common.stitch_platform_empty_text') }}</span>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
