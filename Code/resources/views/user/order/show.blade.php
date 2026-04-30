@extends('frontend.layouts.master')

@section('title', 'Order Detail')

@section('main-content')
    @php
        $points = DB::table('carts')->where('order_id', $order->id)->pluck('points')->first();

        $currency = match($order->currency) {
            'USD' => '$',
            'JPY' => 'YEN ',
            'HKD' => '$HK',
            default => '$',
        };

        if ($order->currency == 'JPY') {
            $orderTotalAmount = number_format($order->total_amount, 0);
        } else {
            $orderTotalAmount = number_format($order->total_amount, 2);
        }
    @endphp

    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.order_detail') }}</span>
                        <h1 class="section-title">{{ __('common.order_detail') }}</h1>
                        <p class="section-copy mt-6">
                            {{ __('common.dashboard_order_detail_intro') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.order_detail') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ url()->previous() }}" class="btn-ghost justify-center">
                            {{ __('common.back') }}
                        </a>
                        <a href="{{ route('order.pdf', $order->id) }}" class="btn-primary justify-center">
                            {{ __('common.generate_pdf') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 space-y-8">
            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">{{ __('common.dashboard_summary_label') }}</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.order_number') }}: {{ $order->order_number }}</h2>
                </div>

                <div class="mt-8 overflow-x-auto">
                    <table class="w-full min-w-[760px] overflow-hidden rounded-[1.5rem] border border-white/10 bg-white/5 text-left">
                        <thead>
                            <tr class="bg-white/5">
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.order_number') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.name') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.email') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.quantity') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.total_amount') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-white/10">
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->order_number }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface">{{ $order->first_name }} {{ $order->last_name }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->email }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $points . ' ' . __('common.points') }}</td>
                                <td class="px-4 py-4 text-sm font-semibold text-on-surface">{{ $currency }}{{ $orderTotalAmount }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ ucwords($order->status) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">{{ __('common.order_information') }}</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.order_information') }}</h2>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.order_number') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">{{ $order->order_number }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.order_date') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">{{ $order->created_at->format('D d M, Y') }} {{ __('common.at') ?? 'at' }} {{ $order->created_at->format('g : i a') }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.quantity') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">{{ $points . ' ' . __('common.points') }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.status') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">{{ ucwords($order->status) }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.total_amount') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">{{ $currency }} {{ $orderTotalAmount }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.payment_method') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">Credit Card</p>
                    </div>
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.payment_status') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">{{ ucwords($order->payment_status) }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.transaction_id') }}</p>
                        <p class="mt-3 text-lg font-semibold text-on-surface">{{ $order->trans_id }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('styles')
    <style>
        .shipping-info h4,
        .order-info h4 {
            text-decoration: underline;
        }
    </style>
@endpush
