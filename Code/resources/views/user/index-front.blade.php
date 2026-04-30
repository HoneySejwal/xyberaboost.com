@extends('frontend.layouts.master')

@section('main-content')
    @php
        $points = DB::table('users')->where('id', auth()->user()->id)->pluck('points')->first();
        $orders = DB::table('orders')->where('user_id', auth()->user()->id)->paginate(100);
        $redeems = App\Models\Cart::where('user_id', auth()->user()->id)->where('status', 'Redeemed')->with('product')->get();
    @endphp

    <main class="pb-20 pt-6 sm:pt-10" x-data="{ tab: 'password' }">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.order_detail') }}</span>
                        <h1 class="section-title">{{ __('common.hi') }}, {{ Auth::user()->name }}</h1>
                        <p class="section-copy mt-6">
                            {{ __('common.dashboard_support_text') }}
                        </p>

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

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.available_credits') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ $points }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.order_history') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ count($orders) }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.points_history') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ $redeems->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 grid gap-8 xl:grid-cols-[280px_minmax(0,1fr)]">
            <aside class="glass-panel p-4 sm:p-6">
                <div class="space-y-3">
                    <button type="button" @click="tab = 'password'" :class="tab === 'password' ? 'nav-link nav-link-active w-full rounded-2xl border border-primary/20 bg-primary/10 px-4 py-4 text-left' : 'nav-link w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-left'">
                        {{ __('common.change_password') }}
                    </button>
                    <button type="button" @click="tab = 'orders'" :class="tab === 'orders' ? 'nav-link nav-link-active w-full rounded-2xl border border-primary/20 bg-primary/10 px-4 py-4 text-left' : 'nav-link w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-left'">
                        {{ __('common.order_history') }}
                    </button>
                    <button type="button" @click="tab = 'points'" :class="tab === 'points' ? 'nav-link nav-link-active w-full rounded-2xl border border-primary/20 bg-primary/10 px-4 py-4 text-left' : 'nav-link w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-left'">
                        {{ __('common.points_history') }}
                    </button>
                </div>
            </aside>

            <div class="space-y-8">
                <section x-show="tab === 'password'" x-cloak class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">{{ __('common.change_password') }}</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.change_password') }}</h2>
                    </div>

                    @if (session('error'))
                        <div class="mt-6 rounded-[1.5rem] border border-error/30 bg-error/10 px-5 py-4 text-sm text-on-surface">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('change.password') }}" id="passwordform" class="mt-8 grid gap-5 md:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.old_password') }}</label>
                            <input type="password" name="current_password" id="oldpswrd" class="topup-input">
                        </div>

                        <div>
                            <label class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.new_password') }}</label>
                            <input id="new_password" type="password" name="new_password" class="topup-input">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.new_password_confirm') }}</label>
                            <input id="cnfrm_pswrd" type="password" name="new_confirm_password" class="topup-input">
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="btn-primary">
                                {{ __('common.change_password') }}
                            </button>
                        </div>
                    </form>
                </section>

                <section x-show="tab === 'orders'" x-cloak class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">{{ __('common.order_history') }}</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.orders') }}</h2>
                    </div>

                    <div class="mt-8 overflow-x-auto">
                        @if(count($orders) > 0)
                            <table class="w-full min-w-[820px] overflow-hidden rounded-[1.5rem] border border-white/10 bg-white/5 text-left">
                                <thead>
                                    <tr class="bg-white/5">
                                        <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.order_number') }}</th>
                                        <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.name') }}</th>
                                        <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.email') }}</th>
                                        <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.quantity') }}</th>
                                        <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.total_amount') }}</th>
                                        <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.status') }}</th>
                                        <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders->reverse() as $order)
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

                                            $orderPoints = DB::table('carts')->where('order_id', $order->id)->pluck('points')->first();
                                        @endphp
                                        <tr class="border-t border-white/10">
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface">{{ $order->first_name }} {{ $order->last_name }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->email }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $orderPoints . ' ' . __('common.points') }}</td>
                                            <td class="px-4 py-4 text-sm font-semibold text-on-surface">{{ $currency }} {{ $orderTotalAmount }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ ucwords($order->status) }}</td>
                                            <td class="px-4 py-4">
                                                <a href="{{ route('user.order.show', $order->id) }}" class="btn-ghost">
                                                    {{ __('common.order_detail') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="rounded-[1.75rem] border border-dashed border-white/15 bg-white/5 px-6 py-12 text-center">
                                <h3 class="text-2xl font-black text-on-surface">{{ __('common.no_orders_found') }}</h3>
                            </div>
                        @endif
                    </div>
                </section>

                <section x-show="tab === 'points'" x-cloak class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">{{ __('common.points_history') }}</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.points_history') }}</h2>
                    </div>

                    <div class="mt-8 overflow-x-auto">
                        <table class="w-full min-w-[760px] overflow-hidden rounded-[1.5rem] border border-white/10 bg-white/5 text-left">
                            <thead>
                                <tr class="bg-white/5">
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.order_id') }}</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.order_number') }}</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.game_name') }}</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.points') }}</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.status') }}</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">{{ __('common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($redeems) > 0)
                                    @foreach($redeems->reverse() as $redeem)
                                        <tr class="border-t border-white/10">
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $redeem->order_id }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface">{{ $redeem->product->title }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $redeem->price }}</td>
                                            <td class="px-4 py-4 text-sm text-on-surface-variant">{{ ucwords($redeem->status) }}</td>
                                            <td class="px-4 py-4">
                                                <span class="rounded-full border border-white/10 bg-black/20 px-3 py-2 text-xs uppercase tracking-[0.16em] text-on-surface-variant">
                                                    {{ __('common.order_detail') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-on-surface-variant">
                                            <h4 class="my-4">{{ __('common.no_orders_found') }}</h4>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script type="text/javascript">
        const url = "{{ route('product.order.income') }}";

        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        var ctx = document.getElementById("myAreaChart");

        if (ctx) {
            axios.get(url)
                .then(function (response) {
                    const data_keys = Object.keys(response.data);
                    const data_values = Object.values(response.data);

                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data_keys,
                            datasets: [{
                                label: "Earnings",
                                lineTension: 0.3,
                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                data: data_values,
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                        callback: function(value) {
                                            return '$' + number_format(value);
                                        }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(function (error) {
                    console.log(error)
                });
        }
    </script>
@endpush
