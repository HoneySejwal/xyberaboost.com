@extends('frontend.layouts.master')

@section('title', 'About Us | EliteLift Gaming')
@section('meta_description', 'Learn more about EliteLift Gaming, our secure player-first approach, and the human skill behind our boosting services.')

@section('main-content')
<main class="pb-20 pt-6 sm:pt-10">
    <section class="page-container">
        <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-surface/85 shadow-soft">
            <div class="hero-orb left-[-5rem] top-[-4rem] h-48 w-48 bg-primary/20"></div>
            <div class="hero-orb bottom-[-5rem] right-[-3rem] h-60 w-60 bg-secondary/20"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,120,42,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(255,196,120,0.12),transparent_28%)]"></div>

            <div class="relative z-10 grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1.05fr_0.95fr] lg:px-12 lg:py-12">
                <div class="flex flex-col justify-between">
                    <div>
                        <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-primary">
                            <span class="h-2 w-2 rounded-full bg-primary shadow-[0_0_18px_rgba(255,120,42,0.9)]"></span>
                            {{ __('common.about_stage_label') }}
                        </div>

                        <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-[-0.04em] text-on-surface sm:text-5xl lg:text-6xl">
                            {{ __('common.about_title') }}
                        </h1>
                        <p class="mt-5 max-w-3xl text-sm leading-7 text-on-surface-variant sm:text-base">
                            {{ __('common.about_intro') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.about') }}
                            </span>
                        </div>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                            <a href="{{ route('product-lists') }}" class="btn-primary">{{ __('common.our_games') }}</a>
                            <a href="{{ route('contact') }}" class="btn-ghost">{{ __('common.contact') }}</a>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.about_metric_trust_label') }}</p>
                            <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.about_metric_trust_value') }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.about_metric_skill_label') }}</p>
                            <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.about_metric_skill_value') }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.about_metric_support_label') }}</p>
                            <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.about_metric_support_value') }}</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel border-white/10 bg-black/30 p-6 sm:p-8">
                    <div class="rounded-[1.8rem] border border-white/10 bg-black/20 p-5">
                        <div class="flex min-h-[260px] items-center justify-center rounded-[1.4rem] border border-white/10 bg-veil-radial p-6 text-center">
                            <div>
                                <img src="{{ asset('images/logo.png') }}" alt="EliteLift Gaming logo" class="mx-auto h-24 w-auto sm:h-28">
                                <p class="mt-6 font-headline text-sm uppercase tracking-[0.28em] text-primary">
                                    {{ __('common.about_logo_tagline') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-[1.75rem] border border-white/10 bg-white/5 p-6">
                        <p class="font-headline text-xs uppercase tracking-[0.24em] text-primary">{{ __('common.about') }}</p>
                        <p class="mt-4 text-base leading-8 text-on-surface-variant">
                            {{ __('common.about_panel_text') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-container mt-8 grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="glass-panel p-6 sm:p-8">
            <span class="section-label">{{ __('common.about_message_label') }}</span>
            <p class="font-headline text-3xl font-black leading-tight text-on-surface sm:text-4xl">
                {{ __('common.about_message_title') }}
            </p>
        </div>

        <div class="glass-panel p-6 sm:p-8">
            <h2 class="font-headline text-3xl font-black text-on-surface sm:text-4xl">
                {{ __('common.about_story_title') }}
            </h2>
            <p class="mt-5 text-base leading-8 text-on-surface-variant">
                {{ __('common.about_story_text_1') }}
            </p>
            <p class="mt-4 text-base leading-8 text-on-surface-variant">
                {{ __('common.about_story_text_2') }}
            </p>
        </div>
    </section>

    <section class="page-container mt-8">
        <div class="mb-10 text-center">
            <span class="section-label">{{ __('common.about_why_label') }}</span>
            <h2 class="section-title">{{ __('common.about_why_title') }}</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="feature-card">
                <span class="material-symbols-outlined text-4xl text-primary">verified_user</span>
                <h3 class="mt-4 font-headline text-xl font-bold text-on-surface">{{ __('common.about_card_secure_title') }}</h3>
                <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ __('common.about_card_secure_text') }}</p>
            </div>

            <div class="feature-card">
                <span class="material-symbols-outlined text-4xl text-primary">visibility</span>
                <h3 class="mt-4 font-headline text-xl font-bold text-on-surface">{{ __('common.about_card_transparent_title') }}</h3>
                <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ __('common.about_card_transparent_text') }}</p>
            </div>

            <div class="feature-card">
                <span class="material-symbols-outlined text-4xl text-primary">sports_esports</span>
                <h3 class="mt-4 font-headline text-xl font-bold text-on-surface">{{ __('common.about_card_skill_title') }}</h3>
                <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ __('common.about_card_skill_text') }}</p>
            </div>

            <div class="feature-card">
                <span class="material-symbols-outlined text-4xl text-primary">trending_up</span>
                <h3 class="mt-4 font-headline text-xl font-bold text-on-surface">{{ __('common.about_card_progress_title') }}</h3>
                <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ __('common.about_card_progress_text') }}</p>
            </div>
        </div>

        <div class="mt-10 glass-panel p-6 sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-3xl">
                    <span class="section-label">{{ __('common.about_next_label') }}</span>
                    <p class="text-lg leading-8 text-on-surface-variant">
                        {{ __('common.about_next_text') }}
                    </p>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('product-lists') }}" class="btn-primary">{{ __('common.our_games') }}</a>
                    <a href="{{ route('contact') }}" class="btn-ghost">{{ __('common.contact') }}</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
