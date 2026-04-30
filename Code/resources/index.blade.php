@extends('frontend.layouts.master')
@section('title','Simple All Beauty || HOME PAGE')
@section('main-content')

     <!-- Hero -->
     <section class="section-hero-2 margin-b-50 margin-t-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-slider-2 swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide slide-2">
                                <div class="row">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="hero-img">
                                            <img src="{{ asset('assets/img/hero/3.jpg') }}" alt="hero">
                                            <p>Flat 20% Off</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="hero-contact">
                                            <div class="hero-detail">
                                                <h2>{{ __('common.indulge') }}<span> {{ __('common.blissful') }}</span>{{ __('common.relaxation') }}</h2>
                                                <p>{{ __('common.luxury_meets_serenity') }}</p>
                                                <a href="{{ url('/product-lists') }}" class="bb-btn-1">{{ __('common.shop_now') }}</a>
                                            </div>
                                            <div class="cat-card">
                                                <ul>
                                                    <li>
                                                        <img src="{{ asset('assets/img/hero/8.jpg') }}" alt="hero">
                                                        <div class="detail">
                                                            <a href="shop-left-sidebar-col-3.html">Baby Suit</a>
                                                            <p>$19</p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <img src="{{ asset('assets/img/hero/9.jpg') }}" alt="hero">
                                                        <div class="detail">
                                                            <a href="shop-left-sidebar-col-3.html">Kids Shoe</a>
                                                            <p>$42</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide slide-2">
                                <div class="row">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="hero-img">
                                            <img src="{{ asset('assets/img/hero/2.jpg') }}" alt="hero">
                                            <p>Flat 50% Off</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="hero-contact">
                                            <div class="hero-detail">
                                                <h2>{{ __('common.rejuvenate') }} <span>{{ __('common.your') }} </span><br>{{ __('common.senses') }}</h2>
                                                <p>{{ __('common.luxurious_treatments') }}</p>
                                                <a href="{{ url('/product-lists') }}" class="bb-btn-1">{{ __('common.shop_now') }}</a>
                                            </div>
                                            <div class="cat-card">
                                                <ul>
                                                    <li>
                                                        <img src="{{ asset('assets/img/hero/6.jpg') }}" alt="hero">
                                                        <div class="detail">
                                                            <a href="shop-left-sidebar-col-3.html">Heels</a>
                                                            <p>$99</p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <img src="{{ asset('assets/img/hero/7.jpg') }}" alt="hero">
                                                        <div class="detail">
                                                            <a href="shop-left-sidebar-col-3.html">Purses</a>
                                                            <p>$487</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide slide-1">
                                <div class="row">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="hero-img">
                                            <img src="{{ asset('assets/img/hero/1.jpg') }}" alt="hero">
                                            <p>Flat 30% Off</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="hero-contact">
                                            <div class="hero-detail">
                                                <h2>{{ __('common.unlock') }}  <span>{{ __('common.your') }} </span><br> {{ __('common.glow') }} </h2>
                                                <p>{{ __('common.expert_care') }}</p>
                                                <a href="{{ url('/product-lists') }}" class="bb-btn-1">{{ __('common.shop_now') }}</a>
                                            </div>
                                            <div class="cat-card">
                                                <ul>
                                                    <li>
                                                        <img src="{{ asset('assets/img/hero/4.jpg') }}" alt="hero">
                                                        <div class="detail">
                                                            <a href="shop-left-sidebar-col-3.html">Shoes</a>
                                                            <p>$55</p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <img src="{{ asset('assets/img/hero/5.jpg') }}" alt="hero">
                                                        <div class="detail">
                                                            <a href="shop-left-sidebar-col-3.html">Watches</a>
                                                            <p>$145</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination swiper-pagination-white"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category -->
    <section class="section-category padding-tb-50">
        <div class="container">
            <div class="row mb-minus-24">
                <div class="col-lg-5 col-12 mb-24">
                    <div class="bb-category-img">
                        <img src="{{ asset('assets/img/category/top-category.jpg') }}" alt="category">
                        <div class="bb-offers">
                            <span>50% Off</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12 mb-24">
                    <div class="bb-category-contact">
                        <div class="category-title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                            <h2>Explore Categories</h2>
                        </div>
                        <div class="bb-category-block owl-carousel">
                            @php
                                $categories = Helper::productCategoryList("all");
                            @endphp
                            @foreach($categories as $category)
                                <div class="bb-category-box category-items-<?=$category->id?>" data-aos="flip-left" data-aos-duration="1000"
                                    data-aos-delay="200">
                                    <div class="category-image">
                                        <img src="<?=asset('assets/img/category')?>/<?=$category->photo?>" alt="<?=$category->title?>">
                                    </div>
                                    <div class="category-sub-contact">
                                        <h5><a href="<?=url('product-cat'.'/'.$category->slug)?>">{{ $category->title }}</a></h5>
                                        <p>{{ Helper::productCountByCategory($category->id) }} items</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Day of the deal -->
    <section class="section-deal padding-tb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title bb-deal" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="section-detail">
                            <h2 class="bb-title">Our Core <span>Services</span></h2>
                            <p>Don't wait. The time will never be just right.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="bb-deal-slider">
                        <div class="bb-deal-block owl-carousel">
                            @php
                                $products = Helper::getRandomProduct(5);
                            @endphp
                            @foreach($products as $product)
                                <div class="bb-deal-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                                    <div class="bb-pro-box">
                                        <div class="bb-pro-img">
                                            <span class="flags">
                                                <span>New</span>
                                            </span>
                                            <a href="javascript:void(0)">
                                                <div class="inner-img">
                                                    @php 
														$photo=explode(',',$product->photo);
													@endphp
                                                    <img class="main-img" src="{{$photo[0]}}" alt="product-1">
                                                    <img class="hover-img" src="{{$photo[0]}}" alt="product-1">
                                                </div>
                                            </a>
                                            <ul class="bb-pro-actions">
                                                <!--<li class="bb-btn-group">
                                                    <a href="javascript:void(0)" title="Wishlist">
                                                        <i class="ri-heart-line"></i>
                                                    </a>
                                                </li>
                                                <li class="bb-btn-group">
                                                    <a href="javascript:void(0)" data-link-action="quickview"
                                                        title="Quick View" data-bs-toggle="modal"
                                                        data-bs-target="#bry_quickview_modal">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>
                                                <li class="bb-btn-group">
                                                    <a href="compare.html" title="Compare">
                                                        <i class="ri-repeat-line"></i>
                                                    </a>
                                                </li>-->
                                                <li class="bb-btn-group">
                                                    <a href="{{route('add-to-cart',$product->slug)}}" title="Add To Cart">
                                                        <i class="ri-shopping-bag-4-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="bb-pro-contact">
                                            <div class="bb-pro-subtitle">
                                                @php
                                                    $rate = ceil($product->getReview->avg('rate'))
                                                @endphp
                                                <span class="bb-pro-rating">
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($rate>=$i)
                                                            <i class="ri-star-fill"></i>
                                                        @else 
                                                            <i class="ri-star-line"></i>
                                                        @endif
                                                    @endfor
                                                </span>
                                            </div>
                                            <h4 class="bb-pro-title"><a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                            </h4>
                                            <div class="bb-price">
                                                <div class="inner-price">
                                                    <span class="new-price">{{ $product->getCurrencySymbol() }} {{number_format($product->price,2)}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="bb-deal-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                                <div class="bb-pro-box">
                                    <div class="bb-pro-img">
                                        <span class="flags">
                                            <span>Hot</span>
                                        </span>
                                        <a href="javascript:void(0)">
                                            <div class="inner-img">
                                                <img class="main-img" src="{{ asset('assets/img/product/2.jpg') }}" alt="product-2">
                                                <img class="hover-img" src="{{ asset('assets/img/product/back-2.jpg') }}"
                                                    alt="product-2">
                                            </div>
                                        </a>
                                        <ul class="bb-pro-actions">
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" title="Wishlist">
                                                    <i class="ri-heart-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" data-link-action="quickview"
                                                    title="Quick View" data-bs-toggle="modal"
                                                    data-bs-target="#bry_quickview_modal">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="compare.html" title="Compare">
                                                    <i class="ri-repeat-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" title="Add To Cart">
                                                    <i class="ri-shopping-bag-4-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bb-pro-contact">
                                        <div class="bb-pro-subtitle">
                                            <a href="shop-left-sidebar-col-4.html">Juice</a>
                                            <span class="bb-pro-rating">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-line"></i>
                                            </span>
                                        </div>
                                        <h4 class="bb-pro-title"><a href="shop-left-sidebar-col-4.html">Organic Apple Juice
                                                Pack</a></h4>
                                        <div class="bb-price">
                                            <div class="inner-price">
                                                <span class="new-price">$15</span>
                                                <span class="item-left">3 Left</span>
                                            </div>
                                            <span class="last-items">100 ml</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bb-deal-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                                <div class="bb-pro-box">
                                    <div class="bb-pro-img">
                                        <a href="javascript:void(0)">
                                            <div class="inner-img">
                                                <img class="main-img" src="{{ asset('assets/img/product/3.jpg') }}" alt="product-3">
                                                <img class="hover-img" src="{{ asset('assets/img/product/back-3.jpg') }}"
                                                    alt="product-3">
                                            </div>
                                        </a>
                                        <ul class="bb-pro-actions">
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" title="Wishlist">
                                                    <i class="ri-heart-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" data-link-action="quickview"
                                                    title="Quick View" data-bs-toggle="modal"
                                                    data-bs-target="#bry_quickview_modal">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="compare.html" title="Compare">
                                                    <i class="ri-repeat-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" title="Add To Cart">
                                                    <i class="ri-shopping-bag-4-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bb-pro-contact">
                                        <div class="bb-pro-subtitle">
                                            <a href="shop-left-sidebar-col-4.html">Juice</a>
                                            <span class="bb-pro-rating">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-line"></i>
                                            </span>
                                        </div>
                                        <h4 class="bb-pro-title"><a href="shop-left-sidebar-col-4.html">Mixed Almond nuts
                                                juice
                                                Pack</a>
                                        </h4>
                                        <div class="bb-price">
                                            <div class="inner-price">
                                                <span class="new-price">$32</span>
                                                <span class="old-price">$39</span>
                                            </div>
                                            <span class="last-items">250 g</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bb-deal-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                                <div class="bb-pro-box">
                                    <div class="bb-pro-img">
                                        <span class="flags">
                                            <span>Sale</span>
                                        </span>
                                        <a href="javascript:void(0)">
                                            <div class="inner-img">
                                                <img class="main-img" src="{{ asset('assets/img/product/4.jpg') }}" alt="product-4">
                                                <img class="hover-img" src="{{ asset('assets/img/product/back-4.jpg') }}"
                                                    alt="product-4">
                                            </div>
                                        </a>
                                        <ul class="bb-pro-actions">
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" title="Wishlist">
                                                    <i class="ri-heart-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" data-link-action="quickview"
                                                    title="Quick View" data-bs-toggle="modal"
                                                    data-bs-target="#bry_quickview_modal">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="compare.html" title="Compare">
                                                    <i class="ri-repeat-line"></i>
                                                </a>
                                            </li>
                                            <li class="bb-btn-group">
                                                <a href="javascript:void(0)" title="Add To Cart">
                                                    <i class="ri-shopping-bag-4-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bb-pro-contact">
                                        <div class="bb-pro-subtitle">
                                            <a href="shop-left-sidebar-col-4.html">Fruits</a>
                                            <span class="bb-pro-rating">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-line"></i>
                                            </span>
                                        </div>
                                        <h4 class="bb-pro-title"><a href="shop-left-sidebar-col-4.html">Fresh Mango Slice
                                                Juice</a></h4>
                                        <div class="bb-price">
                                            <div class="inner-price">
                                                <span class="new-price">$25</span>
                                                <span class="item-left">Out Of Stock</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner-one -->
    <section class="section-banner-one padding-tb-50">
        <div class="container">
            <div class="row mb-minus-24">
                <div class="col-lg-6 col-12 mb-24" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="banner-box bg-box-color-one">
                        <div class="inner-banner-box">
                            <div class="side-image">
                                <img src="{{ asset('assets/img/banner-one/one.png') }}" alt="one">
                            </div>
                            <div class="inner-contact">
                                <h5>Tailored Wellness Experiences</h5>
                                <p>Pamper Yourself with Our Luxurious Services</p>
                                <a href="shop-left-sidebar-col-4.html" class="bb-btn-1">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-24" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="banner-box bg-box-color-two">
                        <div class="inner-banner-box">
                            <div class="side-image">
                                <img src="{{ asset('assets/img/banner-one/two.png') }}" alt="two">
                            </div>
                            <div class="inner-contact">
                                <h5>Where Stress Melts Away</h5>
                                <p>Detox & Rejuvenate with Our Spa Packages</p>
                                <a href="shop-left-sidebar-col-4.html" class="bb-btn-1">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Banner-four -->
     <section class="section-banner-four margin-tb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner-justify-box-contact">
                    <div class="banner-four-box">
                        <span>35% Off</span>
                        <h4>Women's Trendy Fashion Clothes</h4>
                        <a href="javascript:void(0)" class="bb-btn-1">Shop Now</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>


    <!-- Services -->
    <!-- <section class="section-services padding-tb-50">
        <div class="container">
            <div class="row mb-minus-24">
                <div class="col-lg-3 col-md-6 col-12 mb-24" data-aos="flip-up" data-aos-duration="1000"
                    data-aos-delay="200">
                    <div class="bb-services-box">
                        <div class="services-img">
                            <img src="{{ asset('assets/img/services/1.png') }}" alt="services-1">
                        </div>
                        <div class="services-contact">
                            <h4>Free Shipping</h4>
                            <p>Free shipping on all Us order or above $200</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-24" data-aos="flip-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    <div class="bb-services-box">
                        <div class="services-img">
                            <img src="{{ asset('assets/img/services/2.png') }}" alt="services-2">
                        </div>
                        <div class="services-contact">
                            <h4>24x7 Support</h4>
                            <p>Contact us 24 hours a day, 7 days a week</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-24" data-aos="flip-up" data-aos-duration="1000"
                    data-aos-delay="600">
                    <div class="bb-services-box">
                        <div class="services-img">
                            <img src="{{ asset('assets/img/services/3.png') }}" alt="services-3">
                        </div>
                        <div class="services-contact">
                            <h4>{{ __('common.payment_secure') }}</h4>
                            <p>{{ __('common.contact_time') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-24" data-aos="flip-up" data-aos-duration="1000"
                    data-aos-delay="800">
                    <div class="bb-services-box">
                        <div class="services-img">
                            <img src="{{ asset('assets/img/services/4.png') }}" alt="services-4">
                        </div>
                        <div class="services-contact">
                            <h4>Payment Secure</h4>
                            <p>Contact us 24 hours a day, 7 days a week</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

@endsection
