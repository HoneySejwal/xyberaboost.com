@extends('frontend.layouts.master')

@section('main-content')
                        
            <div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url(assets/images/pageheader/bg.jpg);">
            <div class="gt-left-shape">
                <img src="{{ asset('assets/img/shape-1.png') }}" alt="img">
            </div>
            <div class="gt-right-shape">
                <img src="{{ asset('assets/img/shape-2.png') }}" alt="img">
            </div>
            <div class="gt-blur-shape">
                <img src="{{ asset('assets/img/breadcrumb-shape.png') }}" alt="img">
            </div>
            <div class="container">
                <div class="gt-page-heading">
                    <div class="gt-breadcrumb-sub-title">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">  {{ __('common.order_detail') }} </h1>
                    </div>
                    <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <i class="fa-solid fa-house"></i>
                        </li>
                        <li>
                            <a href="{{ route('home') }}">{{ __('common.home') }} :</a>
                        </li>
                        <li class="color">{{ __('common.order_detail') }}</li>
                    </ul>
                </div>
            </div>
        </div>


<section class="cart-area pt-100 pb-100 order-top">
    <div class="container">
      <div class="row">
        <div class="col-12">
            
          <div class="table-content table-responsive">

              @include('user.layouts.notification')

              <div class="row">
                @php
                    $orders=DB::table('orders')->where('user_id',auth()->user()->id)->paginate(10);
                @endphp
                <!-- Order -->
                <div class="col-xl-12 col-lg-12" style="padding-top:50px;padding-bottom:50px;">
                  <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>{{ __('common.order_number') }}</th>
                        <th>{{ __('common.name') }}</th>
                        <th>{{ __('common.email') }}</th>
                        <th>{{ __('common.quantity') }}</th>
                        <th class="text-right">{{ __('common.total_amount') }}</th>
                        <th>{{ __('common.status') }}</th>
                        <th>{{ __('common.action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($orders)>0)
                        @foreach($orders as $order)
                          @php
                            $currency = match($order->currency) {
                                'USD' => '$',
                                'JPY' => '¥',
                                default => '$',
                            };

                            if($order->currency == "USD") {
                                $orderTotalAmount = number_format($order->total_amount, 2);
                            }
                            else {
                                $orderTotalAmount = number_format($order->total_amount, 2);
                            }
                          @endphp
                          <tr>
                              <td>{{$order->order_number}}</td>
                              <td>{{$order->first_name}} {{$order->last_name}}</td>
                              <td>{{$order->email}}</td>
                              <td>{{$order->quantity}}</td>
                              <td class="text-right ft-w-b">{{ $currency }} {{ $orderTotalAmount }}</td>
                              <td>
                                {{ ucwords($order->status) }}
                              </td>
                              <td class="text-center">
                                  <a href="{{route('user.order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                  <!-- <form method="POST" action="{{route('user.order.delete',[$order->id])}}">
                                    @csrf 
                                    @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                  </form> -->
                              </td>
                          </tr>  
                        @endforeach
                        @else
                          <td colspan="8" class="text-center"><h4 class="my-4">{{ __('common.no_orders_found') }}</h4></td>
                        @endif
                    </tbody>
                  </table>

                  <!-- {{$orders->links()}} -->
                </div>
              </div>

          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script type="text/javascript">
  const url = "{{route('product.order.income')}}";

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
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
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
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

// Area Chart Example
var ctx = document.getElementById("myAreaChart");

axios.get(url)
            .then(function (response) {
              const data_keys = Object.keys(response.data);
              const data_values = Object.values(response.data);


var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: data_keys, //["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
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
      data: data_values, //[0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 44660],
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
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
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
            //   vm.answer = 'Error! Could not reach the API. ' + error
            console.log(error)
            });





  </script>
@endpush