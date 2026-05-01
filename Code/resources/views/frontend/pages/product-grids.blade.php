@extends('frontend.layouts.master')

@section('title', 'XyberaBoost || Shop Grid')
@section('description', 'Browse XyberaBoost services with sorting, filtering, and quick access to cart or wishlist.')

@section('main-content')
    @php
        $menu = App\Models\Category::getAllParentWithChild();
        $brands = DB::table('brands')->orderBy('title', 'ASC')->where('status', 'active')->get();
        $max = DB::table('products')->max('price');
    @endphp

    <main class="pb-20 pt-6 sm:pt-10">
        <form action="{{ route('shop.filter') }}" method="POST" class="page-container">
            @csrf

            <section class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">Catalog Grid</span>
                        <h1 class="section-title">Browse every service in one view</h1>
                        <p class="section-copy mt-6">
                            Use the catalog filters to narrow the list, then jump straight to a service page, your wishlist, or the cart flow without changing the backend logic.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">Shop Grid</span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Products</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ $products->total() ?: count($products) }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Recent Posts</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ count($recent_products) }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Filter Ready</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">Price, sort, category</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-8 grid gap-8 xl:grid-cols-[320px_minmax(0,1fr)]">
                <aside class="space-y-6">
                    <div class="glass-panel p-6">
                        <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Categories</h2>
                        <div class="mt-5 space-y-4">
                            @if($menu)
                                @foreach($menu as $cat_info)
                                    <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                        <a href="{{ route('product-cat', $cat_info->slug) }}" class="font-headline text-sm font-bold uppercase tracking-[0.16em] text-on-surface transition hover:text-primary">
                                            {{ $cat_info->title }}
                                        </a>
                                        @if($cat_info->child_cat->count() > 0)
                                            <div class="mt-3 flex flex-col gap-2">
                                                @foreach($cat_info->child_cat as $sub_menu)
                                                    <a href="{{ route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]) }}" class="text-sm text-on-surface-variant transition hover:text-primary">
                                                        {{ $sub_menu->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="glass-panel p-6">
                        <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Shop by Price</h2>
                        <div class="mt-5 rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                            <div id="slider-range" data-min="0" data-max="{{ $max }}" data-currency="$"></div>
                            <div class="mt-5 space-y-4">
                                <label for="amount" class="block text-xs uppercase tracking-[0.18em] text-on-surface-variant">Selected range</label>
                                <input type="text" id="amount" readonly class="topup-input text-base">
                                <input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{ $_GET['price'] }}@endif">
                                <button type="submit" class="btn-primary w-full">{{ __('common.filter') ?: 'Filter' }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel p-6">
                        <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Recent Services</h2>
                        <div class="mt-5 space-y-4">
                            @foreach($recent_products as $product)
                                @php
                                    $photo = explode(',', $product->photo);
                                    $recentImage = $photo[0] ?? 'assets/images/free-fire.jpg';
                                    $recentPrice = ($product->price - ($product->price * $product->discount) / 100);
                                @endphp
                                <a href="{{ route('product-detail', $product->slug) }}" class="flex items-center gap-4 rounded-[1.5rem] border border-white/10 bg-white/5 p-3 transition hover:border-primary/30 hover:bg-primary/5">
                                    <img src="{{ asset($recentImage) }}" alt="{{ $product->title }}" class="h-16 w-16 rounded-2xl object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-on-surface">{{ $product->title }}</p>
                                        <p class="mt-1 text-sm text-on-surface-variant">
                                            <span class="line-through">${{ number_format($product->price, 2) }}</span>
                                            <span class="ml-2 text-primary">${{ number_format($recentPrice, 2) }}</span>
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="glass-panel p-6">
                        <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Brands</h2>
                        <div class="mt-5 flex flex-wrap gap-3">
                            @foreach($brands as $brand)
                                <a href="{{ route('product-brand', $brand->slug) }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-on-surface-variant transition hover:border-primary/30 hover:text-primary">
                                    {{ $brand->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <div class="space-y-6">
                    <div class="glass-panel p-6">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <span class="section-label">Storefront Controls</span>
                                <h2 class="text-3xl font-black tracking-tight text-on-surface">Refine the catalog</h2>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row">
                                <div class="rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-3">
                                    <label for="show" class="mb-2 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">Show</label>
                                    <select id="show" class="bg-transparent text-sm text-on-surface outline-none" name="show" onchange="this.form.submit();">
                                        <option value="">Default</option>
                                        <option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
                                        <option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
                                        <option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
                                        <option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
                                    </select>
                                </div>

                                <div class="rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-3">
                                    <label for="sortBy" class="mb-2 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">Sort By</label>
                                    <select id="sortBy" class="bg-transparent text-sm text-on-surface outline-none" name="sortBy" onchange="this.form.submit();">
                                        <option value="">Default</option>
                                        <option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>Name</option>
                                        <option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Price</option>
                                        <option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category') selected @endif>Category</option>
                                        <option value="brand" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand') selected @endif>Brand</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2 rounded-[1.25rem] border border-primary/20 bg-primary/10 px-4 py-3 text-sm font-semibold text-primary">
                                    <span class="material-symbols-outlined text-base">grid_view</span>
                                    <span>Grid Active</span>
                                    <a href="{{ route('product-lists') }}" class="ml-2 rounded-full border border-primary/20 px-3 py-1 text-xs uppercase tracking-[0.16em] transition hover:bg-primary/10">
                                        List View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 2xl:grid-cols-3">
                        @if(count($products) > 0)
                            @foreach($products as $product)
                                @php
                                    $photo = explode(',', $product->photo);
                                    $productImage = $photo[0] ?? 'assets/images/free-fire.jpg';
                                    $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                @endphp
                                <article class="feature-card flex h-full flex-col overflow-hidden p-0">
                                    <a href="{{ route('product-detail', $product->slug) }}" class="block overflow-hidden">
                                        <img class="h-60 w-full object-cover transition duration-500 hover:scale-105" src="{{ asset($productImage) }}" alt="{{ $product->title }}">
                                    </a>

                                    <div class="flex flex-1 flex-col p-6">
                                        <div class="flex items-start justify-between gap-4">
                                            <h3 class="text-xl font-black tracking-tight text-on-surface">
                                                <a href="{{ route('product-detail', $product->slug) }}" class="transition hover:text-primary">
                                                    {{ $product->title }}
                                                </a>
                                            </h3>
                                            @if($product->discount)
                                                <span class="rounded-full border border-secondary/20 bg-secondary/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-secondary">
                                                    {{ $product->discount }}% Off
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-4 flex items-end gap-3">
                                            <p class="text-2xl font-black text-on-surface">${{ number_format($after_discount, 2) }}</p>
                                            <p class="text-sm text-on-surface-variant line-through">${{ number_format($product->price, 2) }}</p>
                                        </div>

                                        <div class="mt-6 flex flex-wrap gap-3">
                                            <a href="{{ route('product-detail', $product->slug) }}" class="btn-ghost">
                                                View Details
                                            </a>
                                            <a title="Wishlist" href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-ghost">
                                                Add to Wishlist
                                            </a>
                                            <a title="Add to cart" href="{{ route('add-to-cart', $product->slug) }}" class="btn-primary">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @else
                            <div class="md:col-span-2 2xl:col-span-3">
                                <div class="glass-panel px-6 py-12 text-center">
                                    <p class="font-headline text-sm uppercase tracking-[0.22em] text-primary">Catalog Update</p>
                                    <h3 class="mt-4 text-2xl font-black text-on-surface">There are no products.</h3>
                                    <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                                        The filter layout is ready, but this storefront segment does not have active products yet.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="glass-panel px-6 py-5">
                        <div class="catalog-pagination flex justify-center">
                            {{ $products->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>
@endsection

@push('styles')
    <style>
        .catalog-pagination nav > div:first-child {
            display: none;
        }

        .catalog-pagination nav > div:last-child {
            display: flex;
            justify-content: center;
        }

        .catalog-pagination svg {
            width: 1rem;
            height: 1rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
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
