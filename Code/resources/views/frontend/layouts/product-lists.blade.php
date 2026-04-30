@extends('frontend.layouts.master')

@section('title','CroxGame || Game List')

@section('main-content')

    <main>
        <!-- GT Breadcrunb Section Start -->
         <div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/sub_banner_background.png') }}');">
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
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">@foreach ($products as $product_detail)
                                        @endforeach {{$product_detail->cat_info->title}}</h1>
                    </div>
                    <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <i class="fa-solid fa-house"></i>
                        </li>
                        <li>
                            <a href="{{ route('home') }}">{{ __('common.home') }} :</a>
                        </li>
                        <li class="color">
                             {{$product_detail->cat_info->title}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

       <!-- GT News-standard Section Start -->
       <section class="news-standard-section section-padding">
        <div class="container">
            <div class="gt-news-details-wrapper">
                <div class="row g-4">
                     <div class="col-lg-2 col-12 p-0">
                        <div class="gt-main-sideber sticky-style">
                            <div class="gt-single-sideber-widget">
                                <div class="gt-widget-title">
                                    <h3>{{ __('common.games') }}</h3>
                                </div>
                                 <div class="nav flex-column  nav-vertical " id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <ul class="list-unstyled">
            @php
            $categories = Helper::productCategoryList("all")->sortBy('id');
            @endphp
            @foreach($categories as $category)
            <li>
              <a class="nav-link @if($category->title==$product_detail->cat_info->title) active @endif" id="srvceb-tab" href="{{ url('product-cat/'.$category->slug) }}" role="tab" aria-controls="srvcea" aria-selected="false">
                <span class="product-categories__icon">
                  <i class="icon-right-arrow"></i>
                </span> {{ $category->title }} </a>
            </li>
            @endforeach
           
            
          </ul>
        </div>




                              
                            </div>                
                        </div>
                    </div>
                    <div class="col-12 col-lg-10">
                       <div class="tab-content" id="myTabContent">
          <div class="tab-pane accordion-item show active"   id="srvcea" role="tabpanel" aria-labelledby="srvcea-tab">
            <h2 class="accordion-header d-md-none" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">{{ __('common.home') }}</button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
              <div class="accordion-body">
                <div class="gt-news-details-content mb-4">
                       <h3 class="mb-4">   @if(app()->getLocale() == 'ja')
{{$product_detail->cat_info->title_jp}} @else {{$product_detail->cat_info->title}} @endif</h3>
                               <div class="gt-details-image mt-3 mb-4">
                            <img src="{{ env('WEBSITE_URL') . $product_detail->cat_info->photo }}" alt="img">
                        </div>                        
                            <p>  @if(app()->getLocale() == 'ja')
{{$product_detail->cat_info->summary_jp}} @else {{$product_detail->cat_info->summary}} @endif</p>
                        </div>
                        <!-- end detail content -->
                        <!-- start gallery section -->
                      <div class="gt-shop-section fix mb-5">
                        
                             <div class="row g-4 mb-4">
                      
                            @if(count($products))
                            @foreach($products as $product)
                             <div class="col-xl-4 col-lg-4 col-md-6 p-1">
                            <div class="gt-news-card-item">  
                        <div class="gt-shop-card-item mt-0 box">
                            @php 
                            $photo=explode(',',$product->photo);
                            @endphp                       
                           <div class="gt-shop-image mb-2">
                               <img src="{{ url($photo[0])}}" alt="img" class="lazyload">
                            </div>
                       <div class="gt-news-content text-center">
                            <h5>
                                <a href="{{route('product-detail', $product->slug)}}">
                                    {{$product->title}}
                                </a>
                            </h5>
                            <p>{!! \Illuminate\Support\Str::limit($product->summary, 100, '...') !!}</p>
                            <p class="srvce-prce mt-3">{{ $product->getCurrencySymbol() }} {{ Helper::getProductPriceByCurrency(session('currency'), $product) }}</p>
                          
                            <div>
                                
    <form action="{{ route('single-add-to-cart') }}" method="POST">
    @csrf
     <input type="hidden" name="quant[1]" value="1">
  
    <input type="hidden" name="slug" value="{{ $product->slug }}">
 
    <button type="submit" class="gt-theme-btn">
      <i class="far fa-shopping-cart"></i> {{ __('common.add_to_cart') }}
    </button>
 
  </form>
                                
</div>
                        </div>
                      </div>              
                    </div>  
                  </div>
                  @endforeach
                        @else
                            <h4 class="text-warning" style="margin:100px auto;">{{ __('common.no_products') }}</h4>
                        @endif
                   <!-- end grid section -->
                    
                  
                                </div>
                                </div>
                            </div>
                <!-- end gallery section -->
                   
                     
                </div>
               </div>
               </div>
               <!-- end tab pane section -->
                <div class="tab-pane accordion-item "  id="srvceb" role="tabpanel" aria-labelledby="srvceb-tab">
            <h2 class="accordion-header d-md-none" id="headingtwo">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">{{ __('common.home') }}</button>
            </h2>
            
        </div>
      </section>
    </main>

@endsection
@push ('styles')

@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						}); 
                    }
                }
            })
        });
	</script> --}}
	<script>
        $(document).ready(function(){
            
            $(document).ready(function() {
  $('#sel1').change(function() {
    var catlink = $(this).val();
    if (catlink) {
      window.location.href = catlink;
    }
  });
});
            
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }
            
            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>

@endpush