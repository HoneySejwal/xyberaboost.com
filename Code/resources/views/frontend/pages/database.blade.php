@extends('frontend.layouts.master')

@section('title', 'EliteLift Gaming || Database')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        @php
            $products = Helper::getRandomProduct(320);
        @endphp

        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.database') }}</span>
                        <h1 class="section-title">{{ __('common.database') }}</h1>
                        <p class="section-copy mt-6">
                            Browse a wide random selection of active services from the catalog using the same server-rendered product data, detail routes, and add-to-cart behavior already used elsewhere in the storefront.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.database') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Source</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">Random active products</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Flow</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">Detail + cart ready</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">Service Database</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">Explore the catalog</h2>
                </div>

                @if(count($products))
                    <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($products->where('status', 'active') as $product)
                            @php
                                $photo = explode(',', $product->photo);
                                $productImage = $photo[0] ?? 'assets/images/free-fire.jpg';
                            @endphp

                            <article class="feature-card flex h-full flex-col overflow-hidden p-0">
                                <a href="{{ route('product-detail', $product->slug) }}" class="block overflow-hidden">
                                    <img
                                        src="{{ asset($productImage) }}"
                                        alt="{{ $product->title }}"
                                        class="h-56 w-full object-cover transition duration-500 hover:scale-105"
                                    >
                                </a>

                                <div class="flex flex-1 flex-col p-6">
                                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Service Entry</p>
                                    <h3 class="mt-3 text-2xl font-black tracking-tight text-on-surface">
                                        <a href="{{ route('product-detail', $product->slug) }}" class="transition hover:text-primary">
                                            {{ $product->title }}
                                        </a>
                                    </h3>

                                    <p class="mt-4 flex-1 text-sm leading-7 text-on-surface-variant">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($product->summary), 120) }}
                                    </p>

                                    <div class="mt-6 flex items-end justify-between gap-4 border-t border-white/10 pt-5">
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.points') }}</p>
                                            <p class="mt-2 text-2xl font-black text-on-surface">
                                                {{ number_format(Helper::getProductPriceByCurrency('USD', $product), 0) }}
                                            </p>
                                        </div>

                                        <form action="{{ route('single-add-to-cart') }}" method="POST" class="shrink-0">
                                            @csrf
                                            <input type="hidden" name="quant[1]" class="qty-input" data-min="1" data-max="1000" value="1" id="quantity-{{ $product->id }}">
                                            <input type="hidden" name="slug" value="{{ $product->slug }}">
                                            <button type="submit" class="btn-primary">
                                                {{ __('common.add_to_cart') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mt-8 rounded-[2rem] border border-dashed border-white/15 bg-white/5 px-6 py-12 text-center">
                        <p class="font-headline text-sm uppercase tracking-[0.22em] text-primary">Catalog Update</p>
                        <h3 class="mt-4 text-2xl font-black text-on-surface">There are no products.</h3>
                        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                            This section is ready, but no active services are currently available to show here.
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
