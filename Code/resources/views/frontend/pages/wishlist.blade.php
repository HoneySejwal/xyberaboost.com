@extends('frontend.layouts.master')

@section('title', 'Wishlist Page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">Saved Services</span>
                        <h1 class="section-title">Wishlist</h1>
                        <p class="section-copy mt-6">
                            Keep track of the services you want to revisit later, then jump straight into the normal product page or add-to-cart flow when you are ready.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                Wishlist
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Saved Items</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ count(Helper::getAllProductFromWishlist() ?? []) }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Next Step</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">Cart or detail page</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">Wishlist Items</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">Your saved services</h2>
                </div>

                @if(Helper::getAllProductFromWishlist())
                    <div class="mt-8 space-y-5">
                        @foreach(Helper::getAllProductFromWishlist() as $key => $wishlist)
                            @php
                                $photo = explode(',', $wishlist->product['photo']);
                            @endphp

                            <article class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5 sm:p-6">
                                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex items-start gap-4">
                                        <a href="{{ route('product-detail', $wishlist->product['slug']) }}" class="block overflow-hidden rounded-[1.5rem] border border-white/10">
                                            <img src="{{ asset($photo[0]) }}" alt="{{ $wishlist->product['title'] }}" class="h-24 w-24 object-cover">
                                        </a>

                                        <div class="space-y-3">
                                            <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Wishlist Service</p>
                                            <h3 class="text-2xl font-black tracking-tight text-on-surface">
                                                <a href="{{ route('product-detail', $wishlist->product['slug']) }}" class="transition hover:text-primary">
                                                    {{ $wishlist->product['title'] }}
                                                </a>
                                            </h3>
                                            <p class="max-w-2xl text-sm leading-7 text-on-surface-variant">
                                                {!! \Illuminate\Support\Str::limit(strip_tags($wishlist['summary']), 180) !!}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid gap-4 sm:grid-cols-3">
                                        <div class="rounded-[1.25rem] border border-white/10 bg-black/20 px-4 py-4">
                                            <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">Price</p>
                                            <p class="mt-2 text-lg font-bold text-on-surface">${{ $wishlist['amount'] }}</p>
                                        </div>

                                        <div class="flex items-center">
                                            <a href="{{ route('add-to-cart', $wishlist->product['slug']) }}" class="btn-primary w-full justify-center">
                                                Add To Cart
                                            </a>
                                        </div>

                                        <div class="flex items-center">
                                            <a href="{{ route('wishlist-delete', $wishlist->id) }}" class="btn-ghost w-full justify-center">
                                                Remove
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mt-8 rounded-[2rem] border border-dashed border-white/15 bg-white/5 px-6 py-12 text-center">
                        <p class="font-headline text-sm uppercase tracking-[0.22em] text-primary">Wishlist Empty</p>
                        <h3 class="mt-4 text-2xl font-black text-on-surface">There are no saved services yet.</h3>
                        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                            Save interesting products here while you browse, then return when you are ready to order.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('product-grids') }}" class="btn-primary">
                                Continue shopping
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="feature-card">
                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Fast Access</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-on-surface">Return to saved picks quickly</h3>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Use the wishlist as a short list before moving into cart and checkout.</p>
                </div>
                <div class="feature-card">
                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Secure Checkout</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-on-surface">Same backend flow</h3>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Adding a saved item to cart still follows the existing purchase flow and route logic.</p>
                </div>
                <div class="feature-card">
                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Service Detail</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-on-surface">Jump back into research</h3>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Open the original service page anytime to review the breakdown before buying.</p>
                </div>
                <div class="feature-card">
                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Newsletter</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-on-surface">Subscribe to our newsletter</h3>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Stay informed about updates, offers, and new service additions across the storefront.</p>
                </div>
            </div>
        </section>

        @include('frontend.layouts.newsletter')
    </main>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush
