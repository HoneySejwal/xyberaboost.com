@extends('frontend.layouts.master')

@section('title', 'Payment Failed')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-error/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.order_failed_stage_label') }}</span>
                        <h1 class="section-title">{{ __('common.order_failed_title') }}</h1>
                        <p class="section-copy mt-6">{{ __('common.order_failed_intro') }}</p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-error/20 bg-error/10 px-4 py-2 text-error">
                                {{ __('common.order_status') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_failed_metric_payment_label') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.order_failed_metric_payment_value') }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_failed_metric_next_label') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.order_failed_metric_next_value') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="mx-auto max-w-3xl">
                <div class="glass-panel p-6 sm:p-10">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full border border-error/25 bg-error/10 text-error">
                        <span class="material-symbols-outlined text-4xl">error</span>
                    </div>

                    <div class="mt-6 text-center">
                        <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">
                            {{ __('common.payment_error') }}
                        </h2>
                        <p class="mt-4 text-sm leading-8 text-on-surface-variant sm:text-base">
                            {{ __('common.payment_failure_message') }}
                        </p>
                    </div>

                    <div class="mt-8 rounded-[1.75rem] border border-white/10 bg-white/5 px-6 py-6">
                        <h3 class="text-xl font-black text-on-surface">{{ __('common.what_you_can_do') }}</h3>
                        <ul class="mt-4 list-disc space-y-3 pl-6 text-sm leading-7 text-on-surface-variant sm:text-base">
                            <li>{{ __('common.check_payment_details') }}</li>
                            <li>{{ __('common.contact_bank') }}</li>
                            <li>{{ __('common.try_different_payment') }}</li>
                        </ul>
                    </div>

                    <div class="mt-6 rounded-[1.75rem] border border-white/10 bg-white/5 px-6 py-6">
                        <h3 class="text-xl font-black text-on-surface">{{ __('common.need_assistance') }}</h3>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            {{ __('common.reach_out') }}. {{ __('common.we_are_here') }}
                        </p>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                        <a class="btn-primary justify-center" href="{{ route('checkout') }}">
                            {{ __('common.checkout') }}
                        </a>
                        <a class="btn-ghost justify-center" href="{{ route('contact') }}">
                            {{ __('common.contact_support') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
