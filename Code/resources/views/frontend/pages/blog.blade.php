@extends('frontend.layouts.master')

@section('title', 'EliteLift Gaming || Blog Page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 grid gap-10 lg:grid-cols-[1fr_0.92fr] lg:items-center">
                    <div>
                        <span class="section-label">Insights</span>
                        <h1 class="section-title">Blog & updates</h1>
                        <p class="section-copy mt-6 max-w-2xl">
                            Explore news, service updates, gameplay tips, and account guidance through the existing blog system, including search, category filters, tags, and newsletter signup.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                Blog
                            </span>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Articles</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">{{ count($posts) }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Recent Posts</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">{{ count($recent_posts) }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Newsletter</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">Subscribe to our newsletter</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/20 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Reading Guide</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">Stay current with game and service updates</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            This page keeps the same backend-driven post list and sidebar routes, while presenting articles in a cleaner editorial layout that matches the redesigned storefront.
                        </p>

                        <div class="mt-6 space-y-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Existing detail route preserved: <span class="font-semibold text-on-surface">`/blog-detail/{slug}`</span>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Existing search and filter routes preserved: <span class="font-semibold text-on-surface">`/blog/search`, `/blog/filter`</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-6">
                @foreach($posts as $post)
                    <article class="feature-card flex h-full flex-col overflow-hidden p-0">
                        <a href="{{ route('blog.detail', $post->slug) }}" class="block overflow-hidden">
                            <img src="{{ $post->photo }}" alt="{{ $post->title }}" class="h-64 w-full object-cover transition duration-500 hover:scale-105">
                        </a>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex flex-wrap items-center gap-4 text-xs uppercase tracking-[0.16em] text-on-surface-variant">
                                <span class="inline-flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-primary">calendar_month</span>
                                    {{ $post->created_at->format('d M, Y. D') }}
                                </span>
                                <span class="inline-flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-primary">person</span>
                                    {{ $post->author_info->name ?? 'Anonymous' }}
                                </span>
                            </div>

                            <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">
                                <a href="{{ route('blog.detail', $post->slug) }}" class="transition hover:text-primary">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            <p class="mt-4 flex-1 text-sm leading-8 text-on-surface-variant sm:text-base">
                                {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->summary)), 220) }}
                            </p>

                            <div class="mt-6">
                                <a href="{{ route('blog.detail', $post->slug) }}" class="btn-primary">
                                    Continue Reading
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <aside class="space-y-6">
                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Search</h2>
                    <form class="mt-5 space-y-4" method="GET" action="{{ route('blog.search') }}">
                        <input type="text" placeholder="Search Here..." name="search" class="topup-input">
                        <button class="btn-primary w-full justify-center" type="submit">Search</button>
                    </form>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Blog Categories</h2>
                    <div class="mt-5 space-y-3">
                        @foreach(Helper::postCategoryList('posts') as $cat)
                            <a href="{{ route('blog.category', $cat->slug) }}" class="block rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-3 text-sm text-on-surface-variant transition hover:border-primary/30 hover:text-primary">
                                {{ $cat->title }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Recent Posts</h2>
                    <div class="mt-5 space-y-4">
                        @foreach($recent_posts as $post)
                            <a href="{{ route('blog.detail', $post->slug) }}" class="flex items-center gap-4 rounded-[1.5rem] border border-white/10 bg-white/5 p-3 transition hover:border-primary/30 hover:bg-primary/5">
                                <img src="{{ $post->photo }}" alt="{{ $post->title }}" class="h-16 w-16 rounded-2xl object-cover">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-on-surface">{{ $post->title }}</p>
                                    <p class="mt-1 text-sm text-on-surface-variant">{{ $post->created_at->format('d M, y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Tags</h2>
                    <div class="mt-5 flex flex-wrap gap-3">
                        @foreach(Helper::postTagList('posts') as $tag)
                            <a href="{{ route('blog.tag', $tag->title) }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-on-surface-variant transition hover:border-primary/30 hover:text-primary">
                                {{ $tag->title }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Subscribe to our newsletter</h2>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">
                        Get updates when new articles, service announcements, and storefront guidance are published.
                    </p>
                    <form method="POST" action="{{ route('subscribe') }}" class="mt-5 space-y-4">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your email" class="topup-input">
                        <button type="submit" class="btn-primary w-full justify-center">Submit</button>
                    </form>
                </div>
            </aside>
        </section>
    </main>
@endsection

@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }
    </style>
@endpush
