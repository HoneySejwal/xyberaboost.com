@extends('frontend.layouts.master')

@section('title', 'XyberaBoost || Order Track Page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 grid gap-10 lg:grid-cols-[1fr_0.92fr] lg:items-center">
                    <div>
                        <span class="section-label">{{ __('common.order_track_stage_label') }}</span>
                        <h1 class="section-title">{{ __('common.order_track_title') }}</h1>
                        <p class="section-copy mt-6 max-w-2xl">{{ __('common.order_track_intro') }}</p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.order_track_page_title') }}
                            </span>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_track_metric_input_label') }}</p>
                                <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.order_track_metric_input_value') }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_track_metric_route_label') }}</p>
                                <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.order_track_metric_route_value') }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_track_metric_status_label') }}</p>
                                <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.order_track_metric_status_value') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/20 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.order_track_panel_label') }}</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">{{ __('common.order_track_panel_title') }}</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">{{ __('common.order_track_panel_text') }}</p>

                        <div class="mt-6 space-y-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                {{ __('common.order_track_panel_page_route') }}
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                {{ __('common.order_track_panel_submit_route') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="mx-auto max-w-3xl">
                <div class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">{{ __('common.order_track_form_label') }}</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.order_track_form_title') }}</h2>
                    </div>

                    <p class="mt-8 text-sm leading-8 text-on-surface-variant sm:text-base">
                        {{ __('common.order_track_form_text') }}
                    </p>

                    <form class="tracking_form mt-8 space-y-5" action="{{ route('product.track.order') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div>
                            <input type="text" class="topup-input" name="order_number" placeholder="{{ __('common.order_track_placeholder') }}">
                        </div>
                        <div>
                            <button type="submit" value="submit" class="btn-primary w-full justify-center sm:w-auto">
                                {{ __('common.order_track_button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
