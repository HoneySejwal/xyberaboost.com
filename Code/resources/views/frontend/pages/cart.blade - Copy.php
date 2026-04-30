@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')
	<main>
       <!-- GT Breadcrunb Section Start -->
        <div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb.png') }}');">
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
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ __('common.cart') }}</h1>
                    </div>
                    <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <i class="fa-solid fa-house"></i>
                        </li>
                        <li>
                            <a href="{{ route('home') }}">
                                {{ __('common.home') }} :
                            </a>
                        </li>
                        <li class="color">
                            {{ __('common.cart') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- GT Shop Cart Section Start -->
           <div class="cart-section fix section-padding pb-0">
        <div class="container">
            <div class="cart-list-area">
                <div class="table-responsive">
                    <table class="table common-table">
                        <thead data-aos="fade-down">
                            <tr>
                                <th class="text-center">{{ __('common.item') }}</th>
                                <th class="text-center">{{ __('common.price') }}</th>
                                <th class="text-center">{{ __('common.quantity') }}</th>
                                <th class="text-center">{{ __('common.total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(Helper::cartCount())
			                @foreach(Helper::getAllProductFromCart() as $key=>$cart)
                            <tr class="align-items-center py-3">
                                <td>
                                    <div class="cart-item-thumb d-flex align-items-center gap-4">
                                        <a href="{{ route('cart-delete',$cart->id) }}"><i class="fas fa-times"></i></a>
                                        @php
                                            $photo=explode(',',$cart->product['photo']);
                                        @endphp
                                        
                                        <span class="head text-nowrap">{{$cart->product['title']}}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="price-usd">
                                        {{ Helper::getCurrencySymbol(session('currency')) }} </span> {{$cart['price']}}
                                    </span>
                                </td>
                                <td class="price-quantity text-center">
                                    <div
                                    class="quantity d-inline-flex align-items-center justify-content-center gap-1 py-2 px-4 border n50-border_20 text-sm">
                                    <!-- <button class="quantityDecrement"><i class="fal fa-minus"></i></button> -->
                                    <!-- <input type="text" value="1" class="quantityValue"> -->
                                     <input type="text" name="quant[{{$key}}]" value="{{$cart->quantity}}" class="quantityValue" disabled>
                                    <!-- <button class="quantityIncrement"><i class="fal fa-plus"></i></button> -->
                                </div>
                                </td>
                                <td class="text-center">
                                    <span class="price-usd">
                                        {{ Helper::getCurrencySymbol(session('currency')) }} {{$cart['amount']}}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        {{ __('common.no_cart_available') }} <a href="{{route('product-lists')}}" style="color:blue;">{{ __('common.continue_shopping') }}</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="coupon-items d-flex flex-md-nowrap flex-wrap justify-content-between align-items-center gap-4 pt-4">
                    
                    <!-- <button type="button" class="gt-theme-btn">
                        Update Cart
                    </button> -->
                </div>
            </div>
        </div>
       </div>

    <!-- Cart Total section end -->
    <div class="cart-total-area pt-5 section-padding">
        <div class="container">
            <div class="cart-total-items">
                <h3>{{ __('common.cart_total') }}</h3>
                <ul>
                    <li>
                        {{ __('common.subtotal') }} <span class="subtotal">{{ Helper::getCurrencySymbol(session('currency')) }} {{ number_format(Helper::totalCartPrice(), 2) }}</span>
                    </li>
                    <li>
                        {{ __('common.total') }} <span class="price">{{ Helper::getCurrencySymbol(session('currency')) }} {{ number_format(Helper::totalCartPrice(), 2) }}</span>
                    </li>
                </ul>
                <a href="{{ route('checkout') }}" class="gt-theme-btn">
                    {{ __('common.proceed_to_checkout') }}
                </a>
            </div>
        </div>
    </div>                 
  </main>
@endsection
@push('styles')
	
@endpush
@push('scripts')
	<!--<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});
	</script>-->

@endpush
