@extends('frontend.layouts.master')

@php
    $firstProduct = $products->first();
    $categorySource = $category ?? null;

    if ($categorySource instanceof \Illuminate\Support\Collection) {
        $categorySource = $categorySource->first();
    }

    if (is_array($categorySource)) {
        $categorySource = collect($categorySource)->first();
    }

    $categoryInfo = $categorySource ?: optional($firstProduct)->cat_info;
    $categoryTitle = app()->getLocale() === 'ja'
        ? ($categoryInfo->title_jp ?? $categoryInfo->title ?? __('common.our_games'))
        : ($categoryInfo->title ?? __('common.our_games'));
    $categorySummary = app()->getLocale() === 'ja'
        ? ($categoryInfo->summary_jp ?? $categoryInfo->summary ?? '')
        : ($categoryInfo->summary ?? '');
    $categoryPhoto = $categoryInfo->photo ?? 'assets/images/free-fire.jpg';
    $menu = App\Models\Category::getAllParentWithChild();
    $allCategories = Helper::productCategoryList('all')->sortBy('id');
@endphp

@section('title', $categoryTitle)
@section('description', $categorySummary ?: $categoryTitle)

@push('styles')
    <style>
        .product-list-page .will-reveal {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
    </style>
@endpush

@section('main-content')
    <div class="product-list-page pb-24 pt-4 sm:pt-6">
        <section class="page-container mt-4 sm:mt-6">
            <div class="grid gap-6 xl:grid-cols-[300px_minmax(0,1fr)]">
                <aside class="space-y-6">
                    <div class="hud-shell overflow-hidden p-5">
                        <div class="hud-grid-lines"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_platform_grid_label') }}</p>
                            <h2 class="mt-3 text-2xl font-black uppercase tracking-[-0.04em] text-white">{{ __('common.stitch_platform_grid_title') }}</h2>

                            <div class="mt-5 space-y-3">
                                @foreach($menu as $cat_info)
                                    @php
                                        $catTitle = app()->getLocale() === 'ja'
                                            ? ($cat_info->title_jp ?? $cat_info->title)
                                            : $cat_info->title;
                                    @endphp
                                    <div class="storefront-sidebar-card">
                                        <a href="{{ route('product-cat', $cat_info->slug) }}" class="storefront-sidebar-link">
                                            {{ $catTitle }}
                                        </a>

                                        @if($cat_info->child_cat->count() > 0)
                                            <div class="mt-3 space-y-2 border-t border-white/10 pt-3">
                                                @foreach($cat_info->child_cat as $sub_menu)
                                                    @php
                                                        $subTitle = app()->getLocale() === 'ja'
                                                            ? ($sub_menu->title_jp ?? $sub_menu->title)
                                                            : $sub_menu->title;
                                                    @endphp
                                                    <a href="{{ route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]) }}" class="storefront-sidebar-sublink">
                                                        {{ $subTitle }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="space-y-6">
                    <div class="hud-shell overflow-hidden px-6 py-6 sm:px-8">
                        <div class="hud-grid-lines"></div>

                        <div class="relative z-10 flex flex-col gap-5 border-b border-white/10 pb-6 lg:flex-row lg:items-end lg:justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary/80">{{ __('common.stitch_catalog_grid_label') }}</p>
                                <h2 class="mt-3 text-3xl font-black uppercase tracking-[-0.04em] text-white sm:text-4xl">
                                    {{ __('common.stitch_catalog_grid_title') }}
                                </h2>
                            </div>
                            <div class="grid gap-3 sm:grid-cols-3">
                                <div class="storefront-metric-card">
                                    <p>{{ __('common.stitch_catalog_metric_services') }}</p>
                                    <strong>{{ method_exists($products, 'total') ? $products->total() : count($products) }}</strong>
                                    <span>{{ __('common.stitch_catalog_metric_services_value') }}</span>
                                </div>
                                <div class="storefront-metric-card">
                                    <p>{{ __('common.stitch_platform_metric_categories') }}</p>
                                    <strong>{{ $allCategories->count() }}</strong>
                                    <span>{{ __('common.stitch_platform_metric_categories_value') }}</span>
                                </div>
                                <div class="storefront-metric-card">
                                    <p>{{ __('common.stitch_catalog_metric_checkout') }}</p>
                                    <strong>{{ __('common.stitch_catalog_metric_checkout_value') }}</strong>
                                    <span>{{ __('common.stitch_catalog_metric_checkout_note') }}</span>
                                </div>
                            </div>
                        </div>

                        @if(count($products))
                            <div class="relative z-10 mt-8 grid gap-6 md:grid-cols-2 2xl:grid-cols-3">
                                @foreach($products as $product)
                                    @php
                                        $photo = explode(',', $product->photo);
                                        $productImage = $photo[0] ?? 'assets/images/free-fire.jpg';
                                        $productTitle = app()->getLocale() === 'ja'
                                            ? ($product->title_jp ?? $product->title)
                                            : $product->title;
                                        $productSummary = app()->getLocale() === 'ja'
                                            ? ($product->summary_jp ?? $product->summary ?? '')
                                            : ($product->summary ?? '');
                                        $activeCurrency = session('currency', 'USD');
                                        $displayPrice = Helper::getProductPriceByCurrency($activeCurrency, $product);
                                        $currencySymbol = Helper::getCurrencySymbol($activeCurrency);
                                        $priceDecimals = $activeCurrency === 'JPY' ? 0 : 2;
                                    @endphp

                                    <article class="storefront-product-card">
                                        <a href="{{ route('product-detail', $product->slug) }}" class="storefront-product-thumb">
                                            <img
                                                src="{{ asset(ltrim($productImage, '/')) }}"
                                                alt="{{ $productTitle }}"
                                                class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                            >
                                        </a>

                                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/80">{{ __('common.stitch_catalog_card_label') }}</p>
                                                    <h3 class="mt-3 text-2xl font-black uppercase tracking-[-0.04em] text-white">
                                                        <a href="{{ route('product-detail', $product->slug) }}" class="transition hover:text-primary">
                                                            {{ $productTitle }}
                                                        </a>
                                                    </h3>
                                                </div>
                                                <span class="border border-primary/20 bg-primary/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-primary">
                                                    {{ __('common.stitch_catalog_live_label') }}
                                                </span>
                                            </div>

                                            <p class="mt-4 flex-1 text-sm leading-7 text-white/68">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($productSummary), 150) ?: __('common.stitch_catalog_card_fallback') }}
                                            </p>

                                            <div class="mt-6 grid gap-3 border-t border-white/10 pt-5 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/45 sm:grid-cols-2">
                                                <div>
                                                    <p>{{ __('common.stitch_catalog_price_label') }}</p>
                                                    <strong class="mt-2 block text-2xl font-black tracking-normal text-white">
                                                        {{ $currencySymbol }}{{ number_format($displayPrice, $priceDecimals) }}
                                                    </strong>
                                                </div>
                                                <div>
                                                    <p>{{ __('common.stitch_catalog_delivery_label') }}</p>
                                                    <strong class="mt-2 block text-base font-black tracking-normal text-white">{{ __('common.stitch_catalog_delivery_value') }}</strong>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex gap-3">
                                                <a href="{{ route('product-detail', $product->slug) }}" class="btn-secondary flex-1 text-center">
                                                    {{ __('common.stitch_catalog_view_button') }}
                                                </a>
                                                <form action="{{ route('single-add-to-cart') }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <input type="hidden" name="quant[1]" class="qty-input" data-min="1" data-max="1000" value="1" id="quantity-{{ $product->id }}">
                                                    <input type="hidden" name="slug" value="{{ $product->slug }}">
                                                    <button type="submit" class="btn-primary w-full">
                                                        {{ __('common.add_to_cart') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="relative z-10 mt-8 storefront-empty-state">
                                <p>{{ __('common.stitch_catalog_empty_label') }}</p>
                                <h3>{{ __('common.stitch_catalog_empty_title') }}</h3>
                                <span>{{ __('common.stitch_catalog_empty_text') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sel1').change(function () {
                var catlink = $(this).val();
                if (catlink) {
                    window.location.href = catlink;
                }
            });

            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;

                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function (event, ui) {
                        $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }

            if ($("#amount").length > 0 && $("#slider-range").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(
                    m_currency + $("#slider-range").slider("values", 0) +
                    "  -  " + m_currency + $("#slider-range").slider("values", 1)
                );
            }
        });
    </script>
@endpush
