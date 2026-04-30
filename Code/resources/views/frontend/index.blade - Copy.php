@extends('frontend.layouts.master')
@section('main-content')
<main>
  
    <section class="section cta-highlight-banner" style="padding: 300px 0px 140px 0px;">
            <iframe class="cta-highlight-video" data-video-id="fOTgmsqMnQA" id="cta-highlight-video-0" frameborder="0" allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" title="Montra Video 7" width="1640" height="360" src="https://www.youtube.com/embed/fOTgmsqMnQA?autoplay=1&amp;mute=1&amp;controls=0&amp;playsinline=1&amp;modestbranding=1&amp;rel=0&amp;iv_load_policy=3&amp;start=0&amp;end=0&amp;loop=1&amp;playlist=fOTgmsqMnQA&amp;&amp;enablejsapi=1&amp;widgetid=1&amp;forigin=&amp;aoriginsup=1&amp;gporigin=https%3A%2F%2Fmontra2.foxcreation.net%2Fteam.html&amp;vf=1"></iframe>
            <div class="hero-container">
                <div class="cta-highlight-content">
                    <h2 class="cta-highlight-title">{{ __('common.banner_title_top') }}</h2>
                                    <h3 >{{ __('common.banner_title_bottom') }}</h3>
                                    <p>{{ __('common.banner_text') }}</p>
                                    <a href="{{ route('register.form') }}" class="btn btn-accent"> {{ __('common.join_us_today') }} </a>
                    
                </div>
            </div>
        </section>
     <div class="banner__slider overflow-hidden">
       
         
         <section class="section service-content-banner">
            <div class="hero-container">
                <div class="d-flex flex-column gspace-5">
                    <div class="service-title-wrapper">
                        <div class="service-title-heading">
                            <h2>What We Do Best</h2>
                        </div>
                    
                        <div class="service-title-description">
                            <p>
                                From cinematic storytelling to post-production mastery, discover how we bring your vision to life.
                            </p>
                        </div>
                    
                        <div class="service-title-cta">
                            <a href="{{route('database')}}" class="btn btn-accent">Explore All Services</a>
                        </div>
                    </div>
                      
                    <div class="accordion" id="serviceAccordion">
                        @php
                        $category_lists = Helper::productCategoryList('all')->sortBy('id')->take(10);
                    @endphp
                    @foreach($category_lists as $category)
                        <div class="accordion-item {{ $loop->odd ? 'service-acc-1' : 'service-acc-2' }} ">
                            <h2 class="accordion-header service-accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#service{{$loop->iteration}}">
                                    {{ $category->title }}
                                </button>
                            </h2>
                            <div id="service{{$loop->iteration}}" class="accordion-collapse collapse" data-bs-parent="#serviceAccordion">
                                <div class="accordion-body">
                                    <div class="service-content-container">
                                       
                                        <img src="{{ env('WEBSITE_URL') . $category->photo }}">
                                        <div class="service-video-content">
                                            <div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
                                                <div class="col col-md-9">
                                                    <div class="d-flex flex-column-reverse flex-lg-row gspace-2 justify-content-between w-100">
                                                        <div class="service-description-content">
                                                            <p class="mb-0 text-white">{{ $category->summary }}</p>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col col-md-3">
                                                    <div class="d-flex flex-column align-items-end justify-content-center h-100">
                                                        <a href="<?=url('product-cat'.'/'.$category->slug)?>" class="btn btn-accent">{{ __('common.read_more') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach    
                        
                    </div>
                </div>
            </div>
        </section>

      <section class="popin-up"><div class="container">  <p class="accent-color">{{ __('common.disclaimer') }} </p>
          </div>
          </section>
    <section class="popin-up pt-5 pb-5">
        
        
        <div class="container">
              <div class="section-header">
                  
                <h2 class="text-center">
                  <span class="pricing-heading-highlight text-center w-100" style="font-size: 140px;">{{ __('common.points_topup_title') }}</span></h2>
               </div>           
                <div class="poph-cntnt">      
                  <h4 class="mb-4 mt-4">{{ __('common.points_topup_tagline') }}</h4>
                  <p>{{ __('common.points_topup_intro_1') }}</p>
                  <p>{{ __('common.points_topup_intro_2') }}</p>
            <h4 class="mb-4"> {{ __('common.bonus_tier_title') }} </h4>
              <div class="bonus-wtier">
                <table class="w-100">
                    <tr>
                        <th>{{ __('common.bonus_table_range') }} ({{ Helper::getCurrencySymbol(session('currency'))}}) </th>
                        <th>{{ __('common.bonus_table_multiplier') }} </th>
                        <th>{{ __('common.bonus_table_benefit') }} </th>                        

                  </tr>
                  <tr>
        <td>{{session('currency')=='JPY' ? '¥1 – ¥100,000' : '$1 - $600'}}</td>
                   
                    <td> 1× {{ __('common.label_points') }} </td>
                    <td> {{ __('common.bonus_standard') }} </td>
</tr>  
 <tr>
      <td>{{session('currency')=='JPY' ? '¥100,001 – ¥300,000' : '$601 - $2,000'}}</td>              
     
                    <td> 1.5× {{ __('common.label_points') }}  </td>
                    <td> {{ __('common.bonus_50_extra') }}  </td>
</tr>
<tr>
                     <td>{{session('currency')=='JPY' ? '¥300,001 – ¥500,000' : '$2,001 - $3,200'}}</td>   
    
                    <td> 2× {{ __('common.label_points') }}  </td>
                        <td> {{ __('common.bonus_100_extra') }}  </td>
    </tr> 
<tr>
                    <td>{{session('currency')=='JPY' ? __('common.500,001_and_above') : __('common.3201_and_above')}}   </td>
                    <td> 5× {{ __('common.label_points') }}  </td>
                    <td> {{ __('common.bonus_400_extra') }}  </td>
</tr> 
</table>
   <strong class="d-block pt-4">{{ __('common.bonus_note') }}</strong> 
</div>
<div class="lst-xinfo mt-5 mb-4">
    <h3 class="mb-4">{{ __('common.how_it_works_title') }}</h3>

<div class="row row-cols-lg-4 row-cols-md-4 row-cols-4 grid-spacer-4">
                           
                            <div class="col">
                                <div class="card card-service-detail-include">
                                    <div class="d-flex flex-row align-items-center gspace-1">
                                        <i class="fa-solid fa-circle accent-color"></i>
                                        <h5><span> 1. </span> {{ __('common.how_step_1') }}</h5>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-service-detail-include">
                                    <div class="d-flex flex-row align-items-center gspace-1">
                                        <i class="fa-solid fa-circle accent-color"></i>
                                        <h5><span> 2. </span> {{ __('common.how_step_2') }}</h5>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-service-detail-include">
                                    <div class="d-flex flex-row align-items-center gspace-1">
                                        <i class="fa-solid fa-circle accent-color"></i>
                                        <h5><span> 3. </span> {{ __('common.how_step_3') }}</h5>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-service-detail-include cta-card">
                                    <div class="service-detail-cta-container">
                                        <h3><span> 4.  </span>{{ __('common.how_step_4') }}</h3>
                                        <!--
                                        <a href="./contact.html" class="btn btn-service-detail-cta">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="point-winfo mt-5 mb-4">
   
    <div class="text-center mb-4">  
        
<h4>{{ __('common.start_recharge_title') }}</h4>
<p>{{ __('common.start_recharge_text') }}</p>
<div class="clearfix"></div>
<h5 class="clck-winfo"> {{ __('common.start_recharge_button') }} </h5>
    </div>

<form action="{{route('points-add-to-cart')}}" method="POST">
					                  @csrf    
<div class="row justify-content-center m-0">

       <div class="col-xl-1 col-lg-1 col-md-2 col-sm-12 pe-0">
           <!--<p class="curency_xicn mb-0"> {{ Helper::getCurrencySymbol(session('currency'))}} </p>-->
           
           </div>

        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12">
            <!--<label class="form-label">{{ __('common.label_amount') }}</label>-->
            <h5 class="form-label">{{ __('common.label_amount') }}</h5>
            <input type="hidden" name="quant[1]" value="1" id="quantity">
                               <input type="hidden" name="slug" value="points">
              
            
            <div class="input-group">
<span class="input-group-text" style="background-color: var(--p300);border: 1px solid #E50914;">
        <span class="achievement-suffix" style="font-size: 20px;">{{ Helper::getCurrencySymbol(session('currency'))}}</span>
</span>
<input type="number" class="form-control" placeholder="{{ __('common.placeholder_amount', ['currency' => Helper::getCurrencySymbol(session('currency'))]) }}" min="1" max="9999999" name="price" id="price" required oninput="if(this.value > 9999999) this.value = 9999999;">
</div>
            
       </div>
       
<!--
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 p-0 mt-2 row justify-content-center text-center" >
    <div class="col-md-3">
      <label class="form-label">{{ __('common.label_points') }}</label>       
     <input type="number" class="form-control pnter-text" placeholder="{{ __('common.placeholder_points') }}" min="1" name="points" id="points" required readonly>
    </div>
    <div class="col-md-1 form-label text-center" style="font-size: 32px;padding: 10px 0px;width: 20px;height: 10px;
    margin-top: 25px;">+</div>
    <div class="col-md-3">
      <label class="form-label">{{ __('common.bonus_points') }}</label>       
     <input type="number" class="form-control pnter-text" placeholder="{{ __('common.placeholder_points') }}" min="1" name="points" id="bonus_points" required readonly>
    </div>
    <div class="col-md-1 form-label text-center" style="font-size: 32px;padding: 10px 0px;width: 20px;height: 10px;
    margin-top: 25px;">=</div>
    <div class="col-md-3">
      <label class="form-label">{{ __('common.total_points') }}</label>       
     <input type="number" class="form-control pnter-text" placeholder="{{ __('common.placeholder_points') }}" min="1" name="points" id="total_points" required readonly>
    </div>
    
</div>
-->
    <div class="col-md-12">
    <div class="achievement-container mt-2">
                    <div class="achievement-content">
                        <div class="achievement-stat-container">
                            <span class="achievement-stat counter" id="pointst">0</span>
                            <span class="achievement-suffix">+</span>
                        </div>
                        <h5>{{ __('common.label_points') }}</h5>
                    </div>
                    <div class="achievement-content">
                        <div class="achievement-stat-container">
                            <span class="achievement-stat counter" id="bonus_pointst">0</span>
                            <span class="achievement-suffix">=</span>
                        </div>
                        <h5>{{ __('common.bonus_points') }}</h5>
                    </div>
                    <div class="achievement-content">
                        <div class="achievement-stat-container">
                            <span class="achievement-stat counter" id="total_pointst">0</span>
                            <span class="achievement-suffix"></span>
                        </div>
                        <h5>{{ __('common.total_points') }}</h5>
                    </div>
                    
                </div>
    </div>
</div>
<!-- end row section -->
 <div class="text-center mt-4">
     <input type="hidden" class="form-control pnter-text" placeholder="{{ __('common.placeholder_points') }}" min="1" name="points" id="total_points" required readonly>
     <button class="btn btn-accent btn-pricing mt-0" type="submit"> {{ __('common.add_cart') }} </button>
</div>

     </form>    
</div>
</div>
</section> 
   <!-- Features In start -->
    <section id="features-section" class="pt-5 pb-5">        
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="section-header text-center">
                            <!--<h2 class="title">{{ __('common.features_title') }}</h2>-->
                            <h2 class="title">{{ __('common.features_title') }} </h2>
                            <!-- <p class="">{{ __('common.features_subtitle') }}</p> -->
                        </div>
                    </div>
                </div>
                <div class="row pm-none">
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="single-item text-center">                            
                               <i class="icofont-flash"></i>                           
                            <h5>{{ __('common.feature_instant_bonus_title') }}</h5>
                            <p> {{ __('common.feature_instant_bonus_text') }} </p>
                        </div>            

                    </div>
                  
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="single-item text-center">                           
                               <i class="icofont-bolt"></i>                          
                           <h5>{{ __('common.feature_higher_topup_title') }}</h5>
                           <p>{{ __('common.feature_higher_topup_text') }}</p>
                        </div>                      
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="single-item text-center">                           
                              <i class="icofont-ui-check"></i>                          
                           <h5> {{ __('common.feature_transparent_title') }} </h5>
                            <p> {{ __('common.feature_transparent_text') }} </p>
                        </div>
                          
                    </div>
                     <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="single-item text-center ">                           
                               <i class="icofont-sale-discount"></i>                           
                            <h5> {{ __('common.feature_better_value_title') }} </h5>
                            <p> {{ __('common.feature_better_value_text') }} </p>
                        </div>                    
                    </div>                   
                </div>
            </div>      
    </section>
    
</main>
@endsection
        @push('scripts')
        <script>
        $(document).ready(function () {
           var currency = "{{ session('currency') }}";
            //alert('ddd');
            function basicpoints(truepoints){
                truepoints = parseFloat(truepoints);
                if (currency === "HKD") {
               truepoints = truepoints/ 8;
                } else if (currency === "JPY") {
                  truepoints = truepoints / 160
                 }
           else if (currency === "USD") {
             truepoints=truepoints;
           }     
              
                return Math.floor(truepoints);
            }
            function calpoints(truepoints){
                truepoints = parseFloat(truepoints);
                if (currency === "HKD") {
               truepoints = truepoints/ 8;
              } else if (currency === "JPY") {
    //truepoints = truepoints / 160;
                    switch (true) {
    case (truepoints >1 && truepoints < 100001):        
        truepoints=truepoints;
        break;

    case (truepoints > 100000 && truepoints < 300001):
        truepoints = Math.floor(truepoints * 1.5);console.log(truepoints);
        break;

    case (truepoints > 300000 && truepoints < 500001):       
        truepoints = Math.floor(truepoints * 2);
        break;
    case (truepoints > 500000):  
        truepoints = Math.floor(truepoints * 5);
        break;
               
        default:      
        truepoints=truepoints;
        break;
}
                  truepoints = truepoints / 160
                 }
           else if (currency === "USD") {
              switch (true) {
    case (truepoints >1 && truepoints < 601):        
        truepoints=truepoints;
        break;

    case (truepoints > 600 && truepoints < 2001):
        truepoints = Math.floor(truepoints * 1.5);
        break;

    case (truepoints > 2000 && truepoints < 3201):       
        truepoints = Math.floor(truepoints * 2);
        break;
    case (truepoints > 3200):  
        truepoints = Math.floor(truepoints * 5);
        break;
               
        default:      
        truepoints=truepoints;
        break;
} 
           }     
              
                return Math.floor(truepoints);
            }
            
        $('#price').on('keyup', function () {
    let value = $(this).val();         
    $('#points').val(basicpoints(value));
    $('#bonus_points').val(calpoints(value)-basicpoints(value));
    $('#total_points').val(calpoints(value));
   
    //$('#pointst').text(basicpoints(value));        
    $('#pointst').text(basicpoints(value));
    $('#bonus_pointst').text(calpoints(value)-basicpoints(value));
    $('#total_pointst').text(calpoints(value));        
});
            
});
            </script>
        @endpush('scripts')
