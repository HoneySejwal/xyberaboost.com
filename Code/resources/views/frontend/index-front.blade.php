@extends('frontend.layouts.master')

@section('main-content')
    @php
        $points = DB::table('users')->where('id', auth()->user()->id)->pluck('points')->first();
        $orders = DB::table('orders')->where('user_id', auth()->user()->id)->paginate(10);
    @endphp

    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.dashboard_label') }}</span>
                        <h1 class="section-title">{{ __('common.dashboard_title') }}</h1>
                        <p class="section-copy mt-6">{{ __('common.dashboard_intro') }}</p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.dashboard_label') }}
                            </span>
                            <a href="{{ route('user.logout') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-error/40 hover:text-error">
                                {{ __('common.logout') }}
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.available_credits') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ $points }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_history') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ count($orders) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            @include('user.layouts.notification')
        </section>

        <section class="page-container mt-8">
            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">{{ __('common.dashboard_orders_label') }}</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.dashboard_orders_title') }}</h2>
                </div>

                <div class="mt-8 overflow-x-auto">
                    <table class="w-full min-w-[920px] overflow-hidden rounded-[1.5rem] border border-white/10 bg-white/5 text-left">
                        <thead>
                            <tr class="bg-white/5">
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">S.N.</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.order_number') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.name') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.total_amount') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.status') }}</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($orders) > 0)
                                @foreach($orders as $order)
                                    @php
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
                                    <tr class="border-t border-white/10">
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->id }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface">
                                            {{ $order->order_number }}
                                            <div class="mt-1 text-xs text-on-surface-variant">{{ $order->created_at->format('d-M-y') }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->first_name }} {{ $order->last_name }}</td>
                                        <td class="px-4 py-4 text-sm font-semibold text-on-surface">{{ $currency }} {{ $orderTotalAmount }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ ucwords($order->status) }}</td>
                                        <td class="px-4 py-4">
                                            <a href="{{ route('user.order.show', $order->id) }}" class="btn-ghost">
                                                {{ __('common.order_detail') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center">
                                        <h4 class="my-4 text-on-surface-variant">{{ __('common.no_orders_found') }}</h4>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection
