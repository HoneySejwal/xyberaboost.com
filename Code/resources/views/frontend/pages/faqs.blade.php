@extends('frontend.layouts.master')

@section('title', 'XyberaBoost || FAQs')

@section('main-content')
    @php
        $faqs = __('common.faq_items');
    @endphp

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
                                {{ __('common.faq_stage_label') }}
                            </div>

                            <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-[-0.04em] text-on-surface sm:text-5xl lg:text-6xl">
                                {{ __('common.faq_title') }}
                            </h1>
                            <p class="mt-5 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                                {{ __('common.faq_intro') }}
                            </p>

                            <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                                <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                    {{ __('common.home') }}
                                </a>
                                <span>/</span>
                                <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                    {{ __('common.faq_page_title') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.faq_metric_items_label') }}</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">{{ count($faqs) }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.faq_metric_window_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.faq_metric_window_value') }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.faq_metric_path_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.faq_metric_path_value') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/30 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.faq_panel_label') }}</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">{{ __('common.faq_panel_title') }}</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            {{ __('common.faq_panel_text') }}
                        </p>

                        <div class="mt-6 space-y-4">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.phone') }}</p>
                                <a href="tel:{{ __('common.company_phone') }}" class="mt-2 block text-lg font-semibold text-on-surface transition hover:text-primary">
                                    {{ __('common.company_phone') }}
                                </a>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.email') }}</p>
                                <a href="mailto:{{ __('common.company_email') }}" class="mt-2 block text-lg font-semibold text-on-surface transition hover:text-primary">
                                    {{ __('common.company_email') }}
                                </a>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.address') }}</p>
                                <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ __('common.company_address') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">{{ __('common.faq_answers_label') }}</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.faq_answers_title') }}</h2>
                </div>

                <div class="mt-8 space-y-4">
                    @foreach($faqs as $index => $faq)
                        <details class="accordion-card px-5 py-4" @if($index === 0) open @endif>
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <span class="rounded-full border border-primary/20 bg-primary/10 px-3 py-2 font-headline text-xs font-bold tracking-[0.18em] text-primary">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-lg font-bold text-on-surface sm:text-xl">{{ $faq['q'] }}</span>
                                </div>
                                <span class="material-symbols-outlined text-primary">expand_more</span>
                            </summary>
                            <div class="pt-5 text-sm leading-8 text-on-surface-variant sm:text-base">
                                {{ $faq['a'] }}
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
