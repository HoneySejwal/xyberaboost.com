@extends('user.layouts.master')

@section('main-content')
    @php
        $orders = DB::table('orders')->where('user_id', auth()->user()->id)->paginate(10);
    @endphp

    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            @include('user.layouts.notification')
        </section>

        <section class="page-container mt-4">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.dashboard_label') }}</span>
                        <h1 class="section-title">{{ __('common.dashboard_title') }}</h1>
                        <p class="section-copy mt-6">
                            {{ __('common.dashboard_intro') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.dashboard_label') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.orders') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ count($orders) }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.dashboard_overview_label') }}</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ __('common.dashboard_overview_value') }}</p>
                        </div>
                    </div>
                </div>
            </div>
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
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Order No.</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Name</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Email</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Quantity</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Total Amount</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Status</th>
                                <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Action</th>
                            </tr>
                        </thead>
                        <tfoot class="hidden">
                            <tr>
                                <th>S.N.</th>
                                <th>Order No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if(count($orders) > 0)
                                @foreach($orders as $order)
                                    <tr class="border-t border-white/10">
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->id }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface">{{ $order->order_number }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->first_name }} {{ $order->last_name }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->email }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $order->quantity }}</td>
                                        <td class="px-4 py-4 text-sm font-semibold text-on-surface">${{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-4 py-4">
                                            @if($order->status == 'new')
                                                <span class="rounded-full border border-primary/30 bg-primary/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-primary">{{ $order->status }}</span>
                                            @elseif($order->status == 'process')
                                                <span class="rounded-full border border-warning/30 bg-warning/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-warning">{{ $order->status }}</span>
                                            @elseif($order->status == 'delivered')
                                                <span class="rounded-full border border-success/30 bg-success/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-success">{{ $order->status }}</span>
                                            @else
                                                <span class="rounded-full border border-error/30 bg-error/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-error">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('user.order.show', $order->id) }}" class="btn-ghost">
                                                    {{ __('common.view_more') }}
                                                </a>
                                                <form method="POST" action="{{ route('user.order.delete', [$order->id]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn-ghost border-error/30 text-error hover:bg-error/10 dltBtn" data-id="{{ $order->id }}">
                                                        {{ __('common.delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center">
                                        <h4 class="my-4 text-on-surface-variant">{{ __('common.no_orders_found') }}</h4>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-6 flex justify-end">
                        {{ $orders->links() }}
                    </div>
                </div>
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
