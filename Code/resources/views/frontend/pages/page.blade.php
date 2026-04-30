@extends('frontend.layouts.master')

@section('title', $page_data->page_title)
@section('description', 'Policy')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 grid gap-10 lg:grid-cols-[1fr_0.92fr] lg:items-center">
                    <div>
                        <span class="section-label">CMS Page</span>
                        <h1 class="section-title">{{ $page_data->page_title }}</h1>
                        <p class="section-copy mt-6 max-w-2xl">
                            This page is rendered from the existing CMS content system and keeps the same server-rendered title and HTML body while adopting the new storefront presentation.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ $page_data->page_title }}
                            </span>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/20 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Content Source</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">Server-rendered CMS content</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            The body below still comes directly from the saved HTML in `page_desc`, so existing policy pages and static content continue to work without backend changes.
                        </p>
                        <div class="mt-6 space-y-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Existing data field preserved: <span class="font-semibold text-on-surface">`$page_data->page_title`</span>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Existing HTML body preserved: <span class="font-semibold text-on-surface">`$page_data->page_desc`</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="glass-panel p-6 sm:p-8 lg:p-10">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">Page Content</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ $page_data->page_title }}</h2>
                </div>

                <div class="cms-content mt-8 text-on-surface-variant">
                    {!! $page_data->page_desc !!}
                </div>
            </div>
        </section>
    </main>
@endsection

@push('styles')
    <style>
        .cms-content h1,
        .cms-content h2,
        .cms-content h3,
        .cms-content h4,
        .cms-content h5,
        .cms-content h6 {
            color: #f8fafc;
            font-family: var(--font-headline, inherit);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-top: 1.5rem;
            margin-bottom: 0.9rem;
            text-transform: capitalize;
        }

        .cms-content h2:first-child {
            display: none;
        }

        .cms-content p,
        .cms-content li {
            font-size: 1rem;
            line-height: 1.95;
        }

        .cms-content ul,
        .cms-content ol {
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .cms-content a {
            color: #99f7ff;
        }
    </style>
@endpush
