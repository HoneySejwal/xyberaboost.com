@extends('frontend.layouts.master')

@php
    $productTitle = app()->getLocale() === 'ja'
        ? ($product_detail->title_jp ?? $product_detail->title)
        : $product_detail->title;
    $productSummary = app()->getLocale() === 'ja'
        ? ($product_detail->summary_jp ?? $product_detail->summary)
        : $product_detail->summary;
    $productDescription = app()->getLocale() === 'ja'
        ? ($product_detail->description_jp ?? $product_detail->description)
        : $product_detail->description;
    $productExtras = app()->getLocale() === 'ja'
        ? ($product_detail->extra_description_jp ?? $product_detail->extra_description)
        : $product_detail->extra_description;
    $photo = explode(',', $product_detail->photo);
    $heroImage = $photo[0] ?? $product_detail->photo;
@endphp

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="copyright" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{ strip_tags($productSummary) }}">
    <meta property="og:url" content="{{ route('product-detail', $product_detail->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $productTitle }}">
    <meta property="og:image" content="{{ asset($product_detail->photo) }}">
    <meta property="og:description" content="{{ strip_tags($productDescription) }}">
@endsection

@section('title', $productTitle)
@section('description', strip_tags($productSummary))

@section('main-content')
    <main class="pb-24 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="hud-shell storefront-hero-frame overflow-hidden px-6 py-8 sm:px-8 lg:px-10 lg:py-10">
                <div class="hud-grid-lines"></div>

                <div class="relative z-10 grid gap-8 xl:grid-cols-[minmax(0,1.12fr)_420px]">
                    <div class="space-y-6">
                        <div class="storefront-image-frame">
                            <img src="{{ asset(ltrim($heroImage, '/')) }}" alt="{{ $productTitle }}" class="h-full min-h-[360px] w-full object-cover">
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="storefront-metric-card">
                                <p>{{ __('common.stitch_detail_metric_price') }}</p>
                                <strong>{{ number_format($product_detail->price, 0) }}</strong>
                                <span>{{ __('common.points') }}</span>
                            </div>
                            <div class="storefront-metric-card">
                                <p>{{ __('common.stitch_detail_metric_support') }}</p>
                                <strong>{{ __('common.stitch_detail_metric_support_value') }}</strong>
                                <span>{{ __('common.stitch_detail_metric_support_note') }}</span>
                            </div>
                            <div class="storefront-metric-card">
                                <p>{{ __('common.stitch_detail_metric_route') }}</p>
                                <strong>{{ __('common.stitch_detail_metric_route_value') }}</strong>
                                <span>{{ __('common.stitch_detail_metric_route_note') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="inline-flex items-center gap-3 border border-primary/25 bg-primary/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.28em] text-primary">
                            <span class="h-2 w-2 rounded-full bg-primary shadow-[0_0_18px_rgba(249,115,22,0.85)]"></span>
                            {{ __('common.stitch_detail_chip') }}
                        </div>

                        <div class="storefront-panel p-6 sm:p-8">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_detail_kicker') }}</p>
                            <h1 class="mt-4 text-4xl font-black uppercase tracking-[-0.04em] text-white sm:text-5xl">{{ $productTitle }}</h1>
                            <p class="mt-5 text-sm leading-8 text-white/72 sm:text-base">{!! $productSummary !!}</p>

                            <div class="mt-6 flex flex-wrap items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/55">
                                <a href="{{ route('home') }}" class="border border-white/10 bg-white/5 px-3 py-2 text-white transition hover:border-primary/40 hover:text-primary">
                                    {{ __('common.home') }}
                                </a>
                                <span>/</span>
                                <span class="border border-primary/20 bg-primary/10 px-3 py-2 text-primary">{{ $productTitle }}</span>
                            </div>
                        </div>

                        <div class="storefront-panel p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_detail_briefing_label') }}</p>
                            <h2 class="mt-3 text-2xl font-black uppercase tracking-[-0.04em] text-white">{{ __('common.stitch_detail_briefing_title') }}</h2>
                            <p class="mt-3 text-sm leading-7 text-white/72">{{ __('common.stitch_detail_briefing_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_390px]">
            <div class="space-y-8">
                <div class="hud-shell overflow-hidden px-6 py-8 sm:px-8">
                    <div class="hud-grid-lines"></div>
                    <div class="relative z-10">
                        <div class="flex flex-col gap-4 border-b border-white/10 pb-6">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_detail_setup_label') }}</p>
                            <h2 class="text-3xl font-black uppercase tracking-[-0.04em] text-white sm:text-4xl">{{ __('common.stitch_detail_setup_title') }}</h2>
                            <p class="max-w-3xl text-sm leading-7 text-white/66 sm:text-base">{{ __('common.stitch_detail_setup_text') }}</p>
                        </div>

                        <div class="mt-8 space-y-6">
                            <label class="storefront-option-toggle">
                                <input class="mt-1 h-5 w-5 rounded-none border-white/20 bg-transparent text-primary" type="checkbox" id="addon">
                                <div>
                                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-white">{{ __('common.optional_training') }}</p>
                                    <a href="#optn_tranadd" class="mt-2 inline-flex text-sm font-semibold text-primary transition hover:text-white">
                                        {{ __('common.read_more') }}
                                    </a>
                                </div>
                            </label>

                            <div class="we storefront-slider-panel p-6">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary/80">{{ __('common.number_of_hours') }}</p>
                                        <h3 class="mt-3 text-2xl font-black uppercase tracking-[-0.04em] text-white">{{ __('common.stitch_detail_slider_title') }}</h3>
                                    </div>
                                    <div class="border border-primary/20 bg-primary/10 px-4 py-2 text-sm font-bold text-primary">
                                        {{ __('common.points') }}: <span id="product_price">00</span>
                                    </div>
                                </div>

                                <div class="mt-8 px-1">
                                    <div class="relative pt-8">
                                        <input type="range" min="0" max="10" value="0" class="w-full accent-primary" id="product_slider">
                                        <span class="tooltip1 absolute -top-1 border border-primary/20 bg-surface-container-high px-3 py-1 text-xs font-bold text-primary" id="sliderTooltip">0</span>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('single-add-to-cart') }}" method="POST" class="storefront-order-panel">
                                @csrf
                                <input type="hidden" name="quant[1]" value="1" id="quantity">
                                <input type="hidden" name="slug" value="{{ $product_detail->slug }}">
                                <input type="hidden" name="hours" id="product_quantity" value="0">

                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/45">{{ __('common.stitch_detail_checkout_label') }}</p>
                                        <p class="mt-2 text-lg font-semibold text-white">{{ __('common.stitch_detail_checkout_text') }}</p>
                                    </div>
                                    <button type="submit" class="btn-primary">
                                        {{ __('common.add_to_cart') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="hud-shell overflow-hidden px-6 py-8 sm:px-8">
                    <div class="hud-grid-lines"></div>
                    <div class="relative z-10">
                        <div class="border-b border-white/10 pb-6">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.description') }}</p>
                            <h2 class="mt-3 text-3xl font-black uppercase tracking-[-0.04em] text-white sm:text-4xl">{{ __('common.stitch_detail_description_title') }}</h2>
                        </div>

                        <div class="mt-8 space-y-6 text-white/70">
                            <div class="text-sm leading-8 sm:text-base">{!! $productDescription !!}</div>

                            @if(!empty($productExtras))
                                <div class="storefront-panel p-6">
                                    <ul class="storefront-list text-sm leading-7 sm:text-base">
                                        {!! $productExtras !!}
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div id="optn_tranadd" class="mt-8 storefront-panel p-6 sm:p-8">
                            <div class="space-y-5 text-sm leading-8 text-white/72 sm:text-base">
                                <h3 class="text-2xl font-black uppercase tracking-[-0.04em] text-white">{{ __('common.stitch_training_title') }}</h3>
                                <p>{{ __('common.stitch_training_text_1') }}</p>
                                <p>{{ __('common.stitch_training_text_2') }}</p>
                                <p>{{ __('common.stitch_training_text_3') }}</p>
                                <h5 class="text-xl font-black text-white">{{ __('common.stitch_training_included_title') }}</h5>
                                <ul class="storefront-list">
                                    <li><strong>{{ __('common.stitch_training_item_1_label') }}</strong> {{ __('common.stitch_training_item_1_text') }}</li>
                                    <li><strong>{{ __('common.stitch_training_item_2_label') }}</strong> {{ __('common.stitch_training_item_2_text') }}</li>
                                    <li><strong>{{ __('common.stitch_training_item_3_label') }}</strong> {{ __('common.stitch_training_item_3_text') }}</li>
                                    <li><strong>{{ __('common.stitch_training_item_4_label') }}</strong> {{ __('common.stitch_training_item_4_text') }}</li>
                                </ul>
                                <h5 class="text-xl font-black text-white">{{ __('common.stitch_training_pricing_title') }}</h5>
                                <p>{{ __('common.stitch_training_pricing_text') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-8">
                <div class="hud-shell overflow-hidden p-6 sm:p-8">
                    <div class="hud-grid-lines"></div>
                    <div class="relative z-10 border-b border-white/10 pb-6">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_detail_snapshot_label') }}</p>
                        <h2 class="mt-3 text-3xl font-black uppercase tracking-[-0.04em] text-white">{{ __('common.stitch_detail_snapshot_title') }}</h2>
                    </div>

                    <div class="relative z-10 mt-8 space-y-4 text-sm leading-7 text-white/72">
                        <div class="storefront-panel p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/80">{{ __('common.stitch_detail_snapshot_card_1_label') }}</p>
                            <p class="mt-3">{{ __('common.stitch_detail_snapshot_card_1_text') }}</p>
                        </div>
                        <div class="storefront-panel p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/80">{{ __('common.stitch_detail_snapshot_card_2_label') }}</p>
                            <p class="mt-3">{{ __('common.stitch_detail_snapshot_card_2_text') }}</p>
                        </div>
                        <div class="storefront-panel p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/80">{{ __('common.stitch_detail_snapshot_card_3_label') }}</p>
                            <p class="mt-3">{{ __('common.stitch_detail_snapshot_card_3_text') }}</p>
                        </div>
                    </div>
                </div>
            </aside>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        var currency = "{{ session('currency') }}";

        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById("product_slider");
            const tooltip = document.getElementById("sliderTooltip");
            const priceDisplay = document.getElementById("product_price");
            const quantityInput = document.getElementById("product_quantity");
            const productPrice = 20;

            function updateTooltip() {
                const value = parseInt(slider.value);
                const totalPrice = value * productPrice;

                priceDisplay.textContent = totalPrice.toFixed(0);
                quantityInput.value = value;
                tooltip.textContent = value;

                const sliderWidth = slider.offsetWidth;
                const min = parseInt(slider.min);
                const max = parseInt(slider.max);
                const percent = (value - min) / (max - min);
                const thumbOffset = percent * sliderWidth;

                tooltip.style.left = `${thumbOffset}px`;
            }

            if (slider) {
                slider.addEventListener("input", updateTooltip);
                updateTooltip();
            }

            $('.we').hide();
            $('#addon').change(function () {
                if ($(this).is(':checked')) {
                    $('.we').slideDown();
                } else {
                    $('.we').slideUp();
                }
            });
        });
    </script>
@endpush
