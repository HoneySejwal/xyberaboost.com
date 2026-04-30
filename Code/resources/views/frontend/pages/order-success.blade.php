@extends('frontend.layouts.master')

@section('title', 'Payment Success')

@php
    use App\Models\Order;
    $order = Order::where('trans_id', $transaction_id)->first();
@endphp

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-success/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-primary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.order_success_stage_label') }}</span>
                        <h1 class="section-title">{{ __('common.order_success_title') }}</h1>
                        <p class="section-copy mt-6">{{ __('common.order_success_intro') }}</p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-success/20 bg-success/10 px-4 py-2 text-success">
                                {{ __('common.order_status') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.invoice_number') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ $transaction_id }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_success_metric_payment_label') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.order_success_metric_payment_value') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="mx-auto max-w-3xl">
                <div class="glass-panel p-6 text-center sm:p-10">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full border border-success/25 bg-success/10 text-success">
                        <span class="material-symbols-outlined text-4xl">check_circle</span>
                    </div>

                    <h2 class="mt-6 text-3xl font-black tracking-tight text-on-surface sm:text-4xl">
                        {{ __('common.thank_you_order') }}
                    </h2>

                    <p class="mt-4 text-sm leading-8 text-on-surface-variant sm:text-base">
                        {{ __('common.order_confirmation') }} {{ $transaction_id }}
                    </p>

                    <div class="mt-8 rounded-[1.75rem] border border-white/10 bg-white/5 px-6 py-5">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.invoice_number') }}</p>
                        <p class="mt-3 text-2xl font-black text-on-surface">{{ $transaction_id }}</p>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                        @if($order)
                            <a class="btn-primary justify-center" href="{{ route('user.order.show', $order->id) }}">
                                {{ __('common.view_more') }}
                            </a>
                        @endif
                        <a class="btn-ghost justify-center" href="{{ route('home') }}">
                            {{ __('common.home') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
