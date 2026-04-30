<style>
.car-hours-group {
    position: relative;
    background: #198754e6;
    padding: 8px 10px;
    margin: 4px 40px 0 0;
    border-radius: 6px;
}

.car-hours-group h5 {
    font-size: 14px;
    margin: 0 0 0 0;
    text-transform: capitalize;
    color: #fff;
    font-weight: 300;
}

.car-hours-group a {
    position: absolute;
    right: -7px;
    top: -11px;
    background: #fff;
    color: #000 !important;
    border-radius: 40px;
    padding: 0 0 !important;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.car-hours-group h6 {
    margin: 0 0 0 0;
    font-weight: 600;
}
</style>
<!-- ==========Header Section Starts Here========== -->
<header class="header-section style2">  
        <div class="header-holder">
            <div class="header-menu-part">
              <div class="row">
                    <div class="col-xl-3 col-lg-3 col-12">
                 <div class="header-top">
                    <div class="header-top-area justify-content-end d-flex align-items-center">
                        <ul class="left">
                            <li>
                                <i class="icofont-email"></i> <span>{{ __('common.company_email') }}</span>
                            </li>
                           <!-- <li>
                                <i class="icofont-location-pin"></i> {{ __('common.company_address') }}
                            </li>  -->                              
                        </ul>
                        <div class="d-flex align-items-center justify-content-end me-5">
                            <!--
                            <div class="currency-dropdown-wrapper dropdown me-3">
                                <button class="currency-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                     @php
                                    if(session('currency') == 'HKD') {
                                        print "$ HK";
                                    }
                                    elseif(session('currency') == 'JPY') {
                                        print "¥ Japanese Yen";
                                    }
                                   else {                                        
                                        print "$ US Dollar";
                                    } 
                   @endphp 
                                </button>
                                <ul class="dropdown-menu currency-dropdown-menu">
                                    <li><a href="{{ route('change.currency', 'JPY') }}" class="dropdown-item">¥ Japanese</a></li>
                                    <li><a href="{{ route('change.currency', 'USD') }}" class="dropdown-item">$ US Dollar</a></li>
                                    <li><a href="{{ route('change.currency', 'HKD') }}" class="dropdown-item">$ HK</a></li>
                                </ul>
                            </div>
                            -->
                            <div class="cart-ninfo position-relative">
                               <i class="icofont-cart"></i>
                                @if(Helper::getAllProductFromCart())
                                <span class="cart_info">{{ Helper::totalCartQuantity() }}</span>
                                @else
                                <span class="cart_info">0</span>
                                @endif
                            </div>
                        </div>
                    </div>                
            </div>
            
            <div class="header-bottom d-flex flex-wrap justify-content-between align-items-center">
                <div class="container pe-0">
                <div class="brand-logo d-none d-lg-inline-block">
                    <div class="logo text-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="header-wrapper justify-content-lg-end">
                    <div class="mobile-logo d-lg-none">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo"></a>
                    </div>
                    <div class="menu-area">
                        <ul class="menu">
                            <li class="menu-item-has-children"><a href="{{ route('home') }}">{{ __('common.home')}}</a></li>                    
                            <li class="menu-item-has-children"><a href="{{ route('pages', 'about-us') }}">{{ __('common.about')}}</a></li>
                            <li class="menu-item-has-children">
                                
                                <a style="pointer-events: none;">{{ __('common.our_games')}} <i class="icofont-simple-down dwn-wicon"></i>

</a>
                                
                                <ul class="submenu game_ulst">
                                @php $categories = Helper::productCategoryList("all"); @endphp
                                @foreach($categories->take(42) as $cat_info)
                                    <li><a href="{{ route('product-cat', $cat_info->slug) }}">{{ $cat_info->title }}</a></li>
                                @endforeach
                            </ul>
                            </li>    
                            <!--
                            <li>
                                <a href="{{ route('cat-list', 'PC') }}">PC games</a>
                            </li>                                        
                            -->
                            <!--<li><a href="{{ route('contact') }}">{{ __('common.contact') }}</a></li>-->
                            <li class="menu-item-has-children">
                                <a href="" style="pointer-events: none;">
                                @php
                                    if(session('currency') == 'HKD') {
                                        print "$ HKD";
                                    }
                                    elseif(session('currency') == 'JPY') {
                                        print "¥ JPY";
                                    }
                                   else {                                        
                                        print "$ USD";
                                    } 
                   @endphp  
                   <i class="icofont-simple-down dwn-wicon"></i>
                                </a>
                                
                                <ul class="submenu">
                               <li><a href="{{ route('change.currency', 'JPY') }}" class="dropdown-item">¥ JPY</a></li>
                                    <li><a href="{{ route('change.currency', 'USD') }}" class="dropdown-item">$ USD</a></li>
                                    <!-- <li><a href="{{ route('change.currency', 'HKD') }}" class="dropdown-item">$ HKD</a></li> -->
                            </ul>
                            </li>
                      
                         <li class="menu-item-has-children">
                            <a href="javascript:void(0)">   
                             @php
                                if(session('app_locale') == 'ja') {
                  print '<img src="'.url('assets/img/japan.png').'"> '.__('common.japanese');
                                }
                                else {
                  print '<img src="'.url('assets/img/united-kingdom.png').'">  English';                            
                                }
                            @endphp 
                            <i class="icofont-simple-down dwn-wicon"></i>
                             </a> 
                              <ul class="submenu">
                                 <li><a href="{{ route('change.language', 'en') }}" class="dropdown-item"> <img src="{{ asset('assets/img/united-kingdom.png')}}" class="me-2"> English</a></li>
                                 <li><a href="{{ route('change.language', 'ja') }}" class="dropdown-item"> <img src="{{ asset('assets/img/japan.png')}}" class="me-2"> {{ __('common.japanese') }}</a></li>                                   
                              </ul>
                            </li>
                           <li class="menu-item-has-children">
                                <a href="javascript:void(0)"> {{ __('common.my_account') }}                           
                                <i class="icofont-simple-down dwn-wicon"></i>
                                 </a> 
                              <ul class="submenu">
                                 @auth
                                                <li><a href="{{ route('user') }}" class="dropdown-item"> {{ __('common.my_account') }} </a></li>
                                                <li><a href="{{ route('user.logout') }}" class="dropdown-item">{{ __('common.logout') }}</a></li>
                                            @else
                                                <li><a href="{{ route('login.form') }}" class="dropdown-item">{{ __('common.log_in') }}</a></li>
                                                <li><a href="{{ route('register.form') }}" class="dropdown-item">{{ __('common.sign_up') }}</a></li>
                                            @endauth
                                                                
                              </ul>
                            </li>
  
                        </ul>
                    
        



                       <!-- <div class="ms-auto">
                        @auth
                            <a href="{{ route('user') }}" class="default-button colorbtn1"><i class="icofont-user"></i> <span>{{Auth::user()->name}}</span> </a>
                            <a href="{{ route('user.logout') }}" class="default-button colorbtn1"><i class="icofont-users"></i> <span>{{ __('common.logout') }}</span></a>
                        @else
                            <a href="{{ route('login.form') }}" class="default-button colorbtn1"><i class="icofont-user"></i> <span>{{ __('common.log_in') }}</span> </a>
                            <a href="{{ route('register.form') }}" class="default-button colorbtn1"><i class="icofont-users"></i> <span>{{ __('common.sign_up') }}</span></a>
                        @endauth
                        </div>-->
                        <!-- toggle icons -->
                        <div class="header-bar d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="ellepsis-bar d-lg-none">
                            <i class="icofont-info-square"></i>
                        </div>
                    </div>
                </div>
            </div>
          </div>   
        </div>
    </div>
</header>
<!-- ==========Header Section Ends Here========== -->
 <!-- Offcanvas Area Start -->
<div class="cartfix-area">
    <div class="cartcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="cartcanvas__content">
                <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-3">
                    <h5 class="me-auto">{{ __('common.shopping_cart') }}</h5>
                    <div class="cartcanvas__close">
                        <i class="icofont-close"></i>
                    </div>
                </div>
                <!-- end header title section -->
                @if(Helper::cartCount())
                <ul class="cart-list">
                   
                        @foreach(Helper::getAllProductFromCart() as $key => $cart)
        @if(isset($cart->product['id']) && $cart->product['id'] > 6)
                    
                            <li class="d-flex position-relative align-items-center">
                                <a href="{{ route('cart-delete', $cart->id) }}" class="remove-item">
                                    <i class="icofont-close"></i>
                                </a>
                                 <!--$product_id=$cart->product['id'];-->
                                @php 
                               
                    $photo=explode(',',$cart->product['photo']);
 $product_detail= App\Models\Product::getProductBySlug($cart->product->slug); 
                    
$m=Helper::getProductPriceByCurrency(session('currency'), $cart->product);
                                
                   
            $a=$cart['price']-$product_detail->price;
            $hours=$a/35; $basic=$product_detail->price; 
            $perhour=35;                             
                                                        
                    @endphp
                                <!-- <img src="{{ url($photo[0]) }}" class="img-fluid cart-img me-3" alt="game-img"> -->
                                <div class="cart-info me-4">
                                  
                                    <a href="{{ route('product-detail', $cart->product->slug) }}">{{ $cart->product['title'] }}</a>
                                    @if($a>0)  
                                    <p class="mb-0 text-white" style="font-size: unset;"> <span>{{number_format($basic,0)}} +</span></p>
                                   
                                   
                                    <div class="car-hours-group"><h5>{{$hours}} {{ __('common.hours') }}</h5> <a href="{{ route('trainingdelete', $cart->id) }}"><i class="icofont-close"></i></a>  
            <h6 class="text-white mb-0">( {{$hours}} X {{number_format($perhour, 0)}} )</h6>  </div>
                                    @endif
                                    <p class="mb-0">= 
     {{number_format($cart['price'], 0)}}  redeem points                                       
                                       </p>
                                </div>
                            </li>
                 
        @else
     <li class="d-flex position-relative align-items-center">
                                <a href="{{ route('cart-delete', $cart->id) }}" class="remove-item">
                                    <i class="icofont-close"></i>
                                </a>
                                 <!--$product_id=$cart->product['id'];-->
                                @php 
                               
                    $photo=explode(',',$cart->product['photo']);
 $product_detail= App\Models\Product::getProductBySlug($cart->product->slug); 
                    
$m=Helper::getProductPriceByCurrency(session('currency'), $cart->product);
                                
                    if(session('currency') == 'HKD') {
        $a=$cart['price']-$product_detail->price_hk;
        $hours=$a/257; $basic=$product_detail->price_hk; 
        $perhour=257;                        
                                    }
                                    elseif(session('currency') == 'JPY') {
        $a=$cart['price']-$product_detail->price_jp;
            $hours=$a/5000; $basic=$product_detail->price_jp;
            $perhour=5000;                    
                                    }
                                   elseif(session('currency') == 'USD') {
        $a=$cart['price']-$product_detail->price;
            $hours=$a/35; $basic=$product_detail->price; 
            $perhour=35;                    
                                    }                             
                                                        
                    @endphp
                                <!-- <img src="{{ url($photo[0]) }}" class="img-fluid cart-img me-3" alt="game-img"> -->
                                <div class="cart-info me-4">
                                  
                                    <a href="{{ route('product-detail', $cart->product->slug) }}">{{ $cart->product['title'] }}</a>
                                    
                                    <p class="mb-0">= {{ Helper::getCurrencySymbol(session('currency')) }} 
     {{number_format($cart['price'], session('currency')=='JPY' ? 0 : 2)}}                                         
                                       </p>
                                </div>
                            </li>          
        @endif            
                        @endforeach
                    
                </ul>
                @if(isset($cart->product['id']) && $cart->product['id'] > 6)
                <div class="cart-footer border-top mt-3 pt-3 pb-3 d-flex align-items-center mb-3">
                    @php
                        $total_amount = Helper::totalCartPrice();
                    @endphp
                    <h5 class="me-auto fw-bold mb-0">{{ __('common.total') }} :</h5>
                    <span class="prce-uinfo">
  {{number_format($total_amount, 0)}}   Redeem points                      
                       
                    
                    </span>
                </div>
                <div class="cart-btn d-flex justify-content-center">
             
                     <a href="{{ route('gamecart') }}" class="default-button me-5">{{ __('common.game_cart') }}</a>
                    
                </div>
                @else
                <div class="cart-footer border-top mt-3 pt-3 pb-3 d-flex align-items-center mb-3">
                    @php
                        $total_amount = Helper::totalCartPrice();
                    @endphp
                    <h5 class="me-auto fw-bold mb-0">{{ __('common.total') }} :</h5>
                    <span class="prce-uinfo">{{ Helper::getCurrencySymbol(session('currency')) }}
  {{number_format($total_amount, session('currency')=='JPY' ? 0 : 2)}}                         
                    </span>
                </div>
                <div class="cart-btn d-flex justify-content-center">
                        <a href="{{ route('cart') }}" class="default-button me-5">{{ __('common.view_cart') }}</a>
                        <a href="{{ route('checkout') }}" class="default-button">{{ __('common.checkout') }}</a> 
                   
                </div>
                @endif
                @else
                        <li><p class="welcome-one__text">{{ __('common.no_cart_available') }}</p></li>
                    @endif
                
            </div>
        </div>
    </div>
</div>
<!-- Offcanvas Overlay -->
<div class="offcanvas__overlay"></div>