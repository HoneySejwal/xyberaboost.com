@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10 checkout-page">
        <form name="frmCheckout" id="frmCheckout" class="form page-container" method="POST" action="{{route('cart.order')}}">
            @csrf

            <section class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-surface/85 shadow-soft">
                <div class="hero-orb left-[-5rem] top-[-4rem] h-48 w-48 bg-primary/20"></div>
                <div class="hero-orb bottom-[-5rem] right-[-3rem] h-60 w-60 bg-secondary/20"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,120,42,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(255,196,120,0.12),transparent_28%)]"></div>

                <div class="relative z-10 grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1.08fr_0.92fr] lg:px-12 lg:py-12">
                    <div class="flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-primary">
                                <span class="h-2 w-2 rounded-full bg-primary shadow-[0_0_18px_rgba(255,120,42,0.9)]"></span>
                                {{ __('common.checkout_stage_label') }}
                            </div>

                            <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-[-0.04em] text-on-surface sm:text-5xl lg:text-6xl">
                                {{ __('common.checkout_title') }}
                            </h1>
                            <p class="mt-5 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                                {{ __('common.checkout_intro') }}
                            </p>

                            <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                                <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                    {{ __('common.home') }}
                                </a>
                                <span>/</span>
                                <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                    {{ __('common.checkout') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.total') }}</p>
                                <p class="mt-3 text-2xl font-black text-on-surface">
                                    {{ Helper::getCurrencySymbol(session('currency')) }}
                                    {{ number_format(Helper::totalCartPrice(), session('currency')=='JPY' ? 0 : 2) }}
                                </p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.checkout_metric_security_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.checkout_metric_security_value') }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.checkout_metric_flow_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.checkout_metric_flow_value') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/30 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.checkout_panel_label') }}</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">{{ __('common.checkout_panel_title') }}</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            {{ __('common.checkout_panel_text') }}
                        </p>

                        <div class="mt-6 space-y-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                {{ __('common.checkout_panel_route_note') }}
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                {{ __('common.checkout_panel_payment_note') }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_420px]">
                <div class="space-y-8">
                    <div class="glass-panel p-6 sm:p-8">
                        <div class="border-b border-white/10 pb-6">
                            <span class="section-label">{{ __('common.billing_details') }}</span>
                            <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.billing_details') }}</h2>
                        </div>

                        <div class="mt-8 checkout-form-card">
                        <div class="checkout-form-meta">
                            <p>{{ __('common.checkout_billing_note') }}</p>
                        </div>
                        <div class="row m-0">
                            <div class="col-md-6 col-12 p-2 ps-0">                               
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="{{ __('common.first_name') }}" value="{{ auth()->user()->first_name ?? '' }}">
                                @error('first_name')
                                    <span class='text-danger' id="name-error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-12 p-2">                               
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="{{ __('common.last_name') }}" value="{{ auth()->user()->last_name ?? '' }}">
                                @error('last_name')
                                    <span class='text-danger' id="name-error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row m-0">
                            <div class="col-md-6 col-12 p-2 ps-0">                               
                                <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('common.email') }}" value="{{ auth()->user()->email }}">
                                @error('email')
                                    <span class='text-danger'>{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-12 p-2">                                       
                                <input type="tel" name="phone" id="phone" class="form-control" placeholder="{{ __('common.phone') }}" value="{{ auth()->user()->phone }}" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                @error('phone')
                                    <span class='text-danger'>{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row m-0">
                            <div class="col-md-12 col-12 p-1 ps-0">                               
                                <input type="text" name="address1" id="address" class="form-control" placeholder="{{ __('common.address') }}" value="{{ auth()->user()->address }}">
                                @error('address')
                                    <span class='text-danger'>{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row m-0">
                            <div class="col-md-6 col-12 p-2 ps-0">                               
                                <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('common.town_city') }}" value="{{ auth()->user()->city }}">
                                @error('city')
                                    <span class='text-danger'>{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-12 p-2">                                       
                                <input type="text" name="post_code" id="post_code" pattern="[0-9]*" class="form-control" placeholder="{{ __('common.zip_code') }}" value="{{ auth()->user()->zip }}">
                                @error('post_code')
                                    <span class='text-danger'>{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row m-0">
                            <div class="col-md-6 col-12 p-2 ps-0">                               
                                <input type="text" name="state" id="state" class="form-control" placeholder="{{ __('common.state') }}" value="{{ auth()->user()->state }}">
                                @error('state')
                                    <span class='text-danger'>{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-12 p-2">                               
                                <div class="custom-select-wrapper">
                                    <select name="country" id="country" class="form-select">
                                                            <option value="">{{ __('common.select_country') }}</option>
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AX">Åland Islands</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="AD">Andorra</option>
                                                            <option value="AO">Angola</option>
                                                            <option value="AI">Anguilla</option>
                                                            <option value="AQ">Antarctica</option>
                                                            <option value="AG">Antigua and Barbuda</option>
                                                            <option value="AR">Argentina</option>
                                                            <option value="AM">Armenia</option>
                                                            <option value="AW">Aruba</option>
                                                            <option value="AU">Australia</option>
                                                            <option value="AT">Austria</option>
                                                            <option value="AZ">Azerbaijan</option>
                                                            <option value="BS">Bahamas</option>
                                                            <option value="BH">Bahrain</option>
                                                            <option value="BD">Bangladesh</option>
                                                            <option value="BB">Barbados</option>
                                                            <option value="BY">Belarus</option>
                                                            <option value="BE">Belgium</option>
                                                            <option value="BZ">Belize</option>
                                                            <option value="BJ">Benin</option>
                                                            <option value="BM">Bermuda</option>
                                                            <option value="BT">Bhutan</option>
                                                            <option value="BO">Bolivia</option>
                                                            <option value="BA">Bosnia and Herzegovina</option>
                                                            <option value="BW">Botswana</option>
                                                            <option value="BV">Bouvet Island</option>
                                                            <option value="BR">Brazil</option>
                                                            <option value="IO">British Indian Ocean Territory</option>
                                                            <option value="VG">British Virgin Islands</option>
                                                            <option value="BN">Brunei</option>
                                                            <option value="BG">Bulgaria</option>
                                                            <option value="BF">Burkina Faso</option>
                                                            <option value="BI">Burundi</option>
                                                            <option value="KH">Cambodia</option>
                                                            <option value="CM">Cameroon</option>
                                                            <option value="CA">Canada</option>
                                                            <option value="CV">Cape Verde</option>
                                                            <option value="KY">Cayman Islands</option>
                                                            <option value="CF">Central African Republic</option>
                                                            <option value="TD">Chad</option>
                                                            <option value="CL">Chile</option>
                                                            <option value="CN">China</option>
                                                            <option value="CX">Christmas Island</option>
                                                            <option value="CC">Cocos [Keeling] Islands</option>
                                                            <option value="CO">Colombia</option>
                                                            <option value="KM">Comoros</option>
                                                            <option value="CG">Congo - Brazzaville</option>
                                                            <option value="CD">Congo - Kinshasa</option>
                                                            <option value="CK">Cook Islands</option>
                                                            <option value="CR">Costa Rica</option>
                                                            <option value="CI">Côte d’Ivoire</option>
                                                            <option value="HR">Croatia</option>
                                                            <option value="CU">Cuba</option>
                                                            <option value="CY">Cyprus</option>
                                                            <option value="CZ">Czech Republic</option>
                                                            <option value="DK">Denmark</option>
                                                            <option value="DJ">Djibouti</option>
                                                            <option value="DM">Dominica</option>
                                                            <option value="DO">Dominican Republic</option>
                                                            <option value="EC">Ecuador</option>
                                                            <option value="EG">Egypt</option>
                                                            <option value="SV">El Salvador</option>
                                                            <option value="GQ">Equatorial Guinea</option>
                                                            <option value="ER">Eritrea</option>
                                                            <option value="EE">Estonia</option>
                                                            <option value="ET">Ethiopia</option>
                                                            <option value="FK">Falkland Islands</option>
                                                            <option value="FO">Faroe Islands</option>
                                                            <option value="FJ">Fiji</option>
                                                            <option value="FI">Finland</option>
                                                            <option value="FR">France</option>
                                                            <option value="GF">French Guiana</option>
                                                            <option value="PF">French Polynesia</option>
                                                            <option value="TF">French Southern Territories</option>
                                                            <option value="GA">Gabon</option>
                                                            <option value="GM">Gambia</option>
                                                            <option value="GE">Georgia</option>
                                                            <option value="DE">Germany</option>
                                                            <option value="GH">Ghana</option>
                                                            <option value="GI">Gibraltar</option>
                                                            <option value="GR">Greece</option>
                                                            <option value="GL">Greenland</option>
                                                            <option value="GD">Grenada</option>
                                                            <option value="GP">Guadeloupe</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="GT">Guatemala</option>
                                                            <option value="GG">Guernsey</option>
                                                            <option value="GN">Guinea</option>
                                                            <option value="GW">Guinea-Bissau</option>
                                                            <option value="GY">Guyana</option>
                                                            <option value="HT">Haiti</option>
                                                            <option value="HM">Heard Island and McDonald Islands</option>
                                                            <option value="HN">Honduras</option>
                                                            <option value="HK">Hong Kong SAR China</option>
                                                            <option value="HU">Hungary</option>
                                                            <option value="IS">Iceland</option>
                                                            <option value="IN">India</option>
                                                            <option value="ID">Indonesia</option>
                                                            <option value="IR">Iran</option>
                                                            <option value="IQ">Iraq</option>
                                                            <option value="IE">Ireland</option>
                                                            <option value="IM">Isle of Man</option>
                                                            <option value="IL">Israel</option>
                                                            <option value="IT">Italy</option>
                                                            <option value="JM">Jamaica</option>
                                                            <option value="JP">Japan</option>
                                                            <option value="JE">Jersey</option>
                                                            <option value="JO">Jordan</option>
                                                            <option value="KZ">Kazakhstan</option>
                                                            <option value="KE">Kenya</option>
                                                            <option value="KI">Kiribati</option>
                                                            <option value="KW">Kuwait</option>
                                                            <option value="KG">Kyrgyzstan</option>
                                                            <option value="LA">Laos</option>
                                                            <option value="LV">Latvia</option>
                                                            <option value="LB">Lebanon</option>
                                                            <option value="LS">Lesotho</option>
                                                            <option value="LR">Liberia</option>
                                                            <option value="LY">Libya</option>
                                                            <option value="LI">Liechtenstein</option>
                                                            <option value="LT">Lithuania</option>
                                                            <option value="LU">Luxembourg</option>
                                                            <option value="MO">Macau SAR China</option>
                                                            <option value="MK">Macedonia</option>
                                                            <option value="MG">Madagascar</option>
                                                            <option value="MW">Malawi</option>
                                                            <option value="MY">Malaysia</option>
                                                            <option value="MV">Maldives</option>
                                                            <option value="ML">Mali</option>
                                                            <option value="MT">Malta</option>
                                                            <option value="MH">Marshall Islands</option>
                                                            <option value="MQ">Martinique</option>
                                                            <option value="MR">Mauritania</option>
                                                            <option value="MU">Mauritius</option>
                                                            <option value="YT">Mayotte</option>
                                                            <option value="MX">Mexico</option>
                                                            <option value="FM">Micronesia</option>
                                                            <option value="MD">Moldova</option>
                                                            <option value="MC">Monaco</option>
                                                            <option value="MN">Mongolia</option>
                                                            <option value="ME">Montenegro</option>
                                                            <option value="MS">Montserrat</option>
                                                            <option value="MA">Morocco</option>
                                                            <option value="MZ">Mozambique</option>
                                                            <option value="MM">Myanmar [Burma]</option>
                                                            <option value="NA">Namibia</option>
                                                            <option value="NR">Nauru</option>
                                                            <option value="NP">Nepal</option>
                                                            <option value="NL">Netherlands</option>
                                                            <option value="AN">Netherlands Antilles</option>
                                                            <option value="NC">New Caledonia</option>
                                                            <option value="NZ">New Zealand</option>
                                                            <option value="NI">Nicaragua</option>
                                                            <option value="NE">Niger</option>
                                                            <option value="NG">Nigeria</option>
                                                            <option value="NU">Niue</option>
                                                            <option value="NF">Norfolk Island</option>
                                                            <option value="MP">Northern Mariana Islands</option>
                                                            <option value="KP">North Korea</option>
                                                            <option value="NO">Norway</option>
                                                            <option value="OM">Oman</option>
                                                            <option value="PK">Pakistan</option>
                                                            <option value="PW">Palau</option>
                                                            <option value="PS">Palestinian Territories</option>
                                                            <option value="PA">Panama</option>
                                                            <option value="PG">Papua New Guinea</option>
                                                            <option value="PY">Paraguay</option>
                                                            <option value="PE">Peru</option>
                                                            <option value="PH">Philippines</option>
                                                            <option value="PN">Pitcairn Islands</option>
                                                            <option value="PL">Poland</option>
                                                            <option value="PT">Portugal</option>
                                                            <option value="PR">Puerto Rico</option>
                                                            <option value="QA">Qatar</option>
                                                            <option value="RE">Réunion</option>
                                                            <option value="RO">Romania</option>
                                                            <option value="RU">Russia</option>
                                                            <option value="RW">Rwanda</option>
                                                            <option value="BL">Saint Barthélemy</option>
                                                            <option value="SH">Saint Helena</option>
                                                            <option value="KN">Saint Kitts and Nevis</option>
                                                            <option value="LC">Saint Lucia</option>
                                                            <option value="MF">Saint Martin</option>
                                                            <option value="PM">Saint Pierre and Miquelon</option>
                                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                                            <option value="WS">Samoa</option>
                                                            <option value="SM">San Marino</option>
                                                            <option value="ST">São Tomé and Príncipe</option>
                                                            <option value="SA">Saudi Arabia</option>
                                                            <option value="SN">Senegal</option>
                                                            <option value="RS">Serbia</option>
                                                            <option value="SC">Seychelles</option>
                                                            <option value="SL">Sierra Leone</option>
                                                            <option value="SG">Singapore</option>
                                                            <option value="SK">Slovakia</option>
                                                            <option value="SI">Slovenia</option>
                                                            <option value="SB">Solomon Islands</option>
                                                            <option value="SO">Somalia</option>
                                                            <option value="ZA">South Africa</option>
                                                            <option value="GS">South Georgia</option>
                                                            <option value="KR">South Korea</option>
                                                            <option value="ES">Spain</option>
                                                            <option value="LK">Sri Lanka</option>
                                                            <option value="SD">Sudan</option>
                                                            <option value="SR">Suriname</option>
                                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                                            <option value="SZ">Swaziland</option>
                                                            <option value="SE">Sweden</option>
                                                            <option value="CH">Switzerland</option>
                                                            <option value="SY">Syria</option>
                                                            <option value="TW">Taiwan</option>
                                                            <option value="TJ">Tajikistan</option>
                                                            <option value="TZ">Tanzania</option>
                                                            <option value="TH">Thailand</option>
                                                            <option value="TL">Timor-Leste</option>
                                                            <option value="TG">Togo</option>
                                                            <option value="TK">Tokelau</option>
                                                            <option value="TO">Tonga</option>
                                                            <option value="TT">Trinidad and Tobago</option>
                                                            <option value="TN">Tunisia</option>
                                                            <option value="TR">Turkey</option>
                                                            <option value="TM">Turkmenistan</option>
                                                            <option value="TC">Turks and Caicos Islands</option>
                                                            <option value="TV">Tuvalu</option>
                                                            <option value="UG">Uganda</option>
                                                            <option value="UA">Ukraine</option>
                                                            <option value="AE">United Arab Emirates</option>
                                                            <option value="Uk">United Kingdom</option>
                                                            <option value="UY">Uruguay</option>
                                                            <option value="UM">U.S. Minor Outlying Islands</option>
                                                            <option value="VI">U.S. Virgin Islands</option>
                                                            <option value="UZ">Uzbekistan</option>
                                                            <option value="VU">Vanuatu</option>
                                                            <option value="VA">Vatican City</option>
                                                            <option value="VE">Venezuela</option>
                                                            <option value="VN">Vietnam</option>
                                                            <option value="WF">Wallis and Futuna</option>
                                                            <option value="EH">Western Sahara</option>
                                                            <option value="YE">Yemen</option>
                                                            <option value="ZM">Zambia</option>
                                                            <option value="ZW">Zimbabwe</option>
                                                        </select>
                                    <i class="icofont-rounded-down dropdown-icon"></i>
                                </div>
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        </div>
                    </div>

                    <div class="glass-panel p-6 sm:p-8">
                        <div class="border-b border-white/10 pb-6">
                            <span class="section-label">{{ __('common.card_details') }}</span>
                            <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.card_details') }}</h2>
                        </div>

                        <div class="mt-8 checkout-form-card">
                        <div class="checkout-form-meta">
                            <p>{{ __('common.checkout_payment_note') }}</p>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('common.card_holder_name') }}*</label>
                            <input type="text" name="name" id="name_on_card" class="form-control" placeholder="{{ __('common.card_holder_name') }}">
                            <span id="card-name-error" class="text-danger"></span>
                        </div>
                        
                        <div class="mb-3">
                            <label>{{ __('common.card_number') }}*</label>
                            <input type="text" name="card_number" id="card_number" class="form-control cc-number" placeholder="0000 0000 0000 0000">
                            <span id="card-number-error" class="text-danger"></span>
                        </div>
                        
                        <div class="row m-0 mb-3">
                            <div class="col-md-6 col-12 ps-0">
                                <label>{{ __('common.card_expiry') }}</label>
                                <div class="d-flex position-relative">
                                    <input type="number" name="expiry_month" id="expiry_month" class="form-control cardmnth" placeholder="MM" value="12">
                                    <span class="bnicon"> / </span>
                                    <input type="number" name="expiry_year" id="expiry_year" class="form-control cardte cc-year" placeholder="YYYY">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label>{{ __('common.card_cvv') }}</label>
                                <input type="number" name="cvv" id="cvv" class="form-control cc-cvc" placeholder="•••">
                                <span id="card-cvv-error" class="text-danger"></span>
                            </div>
                        </div>
                        
                        <h4 class="heading-info mb-4">{{ __('common.additional_information') }} </h4>
                        <div class="mb-3">
                            <label>{{ __('common.order_information') }}</label>
                            <textarea class="form-control" name="order_notes" placeholder="{{ __('common.add_comments_order') }}"></textarea>
                        </div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-8">
                    <div class="glass-panel p-6 sm:p-8">
                        <div class="border-b border-white/10 pb-6">
                            <span class="section-label">{{ __('common.your_order') }}</span>
                            <h2 class="text-3xl font-black tracking-tight text-on-surface">{{ __('common.your_order') }}</h2>
                        </div>

                        <div class="mt-8 checkout-summary-card">
                            <div class="checkout-form-meta">
                                <p>{{ __('common.checkout_order_note') }}</p>
                            </div>
                            <table class="table w-100">
                            <tr>
                                <th>{{ __('common.product') }}</th>
                                <th>{{ __('common.total') }}</th>
                            </tr>
                            
                            @php
                                $total_amount = Helper::totalCartPrice();
                            @endphp
                            
                            @if(Helper::getAllProductFromCart())
                                @foreach(Helper::getAllProductFromCart() as $key => $cart)
  @php 
                
  $user_id = auth()->check() ? auth()->id() : session('guest');        
$points = App\Models\Cart::where('user_id', $user_id)->where('order_id',null)->pluck('points')->first();                            
                            @endphp                              
                                    <tr>
                                        <td>{{ $points.' '.__('common.points') }}
                                   
                                        </td>
                                        <td>{{ Helper::getCurrencySymbol(session('currency')) }} 
                                           
  {{number_format($cart['price'], session('currency')=='JPY' ? 0 : 2)}}                                         
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            
                            <!-- <tr>
                                <th>{{ __('common.subtotal') }}</th>
                                <td>{{ Helper::getCurrencySymbol(session('currency')) }}
     {{number_format(Helper::totalCartPrice(), session('currency')=='JPY' ? 0 : 2)}}                                     
                                    </td>
                            </tr> -->
                            <tr>
                                <th>{{ __('common.total') }}</th>
                                <td>{{ Helper::getCurrencySymbol(session('currency')) }}
     {{number_format($total_amount, session('currency')=='JPY' ? 0 : 2)}}                                     
                                   </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="glass-panel p-6 sm:p-8">
                        <div class="border-b border-white/10 pb-6">
                            <span class="section-label">{{ __('common.checkout_policy_label') }}</span>
                            <h2 class="text-3xl font-black tracking-tight text-on-surface">{{ __('common.checkout_policy_title') }}</h2>
                        </div>

                        <div class="mt-8 condtn-info">
                        <p class="mb-6 text-sm leading-7 text-on-surface-variant">{{ __('common.checkout_policy_text') }}</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms">
                            <label for="terms">   {{ __('common.agree_terms_text') }} <a href="{{ route('pages', 'terms-conditions') }}">{{ __('common.terms_policy') }}</a></label>
                            
                            
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="privacy" name="privacy">
                            <label for="privacy">  {{ __('common.agree_terms_text') }} <a href="{{ route('pages', 'privacy-policy') }}">{{ __('common.privacy_policy') }}</a></label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" id="delivery" name="delivery" class="form-check-input">
                            <label for="delivery">  {{ __('common.agree_terms_text') }}  <a href="{{ route('pages', 'delivery-policy') }}">{{ __('common.delivery_policy') }}</a></label>
                            
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="refund" name="refund">
                            <label for="refund">  {{ __('common.agree_terms_text') }} <a href="{{ route('pages', 'refund-policy') }}">{{ __('common.refund_policy') }}</a></label>
                        </div>
                        <div class="form-group w-100 row">
      <div class="col-md-8">          
<input type="text" id="captcha" name="captcha" autocomplete="off" class="form-control" placeholder="{{ __('common.fill_captcha') }}" required>
                
    @error('captcha')
    <span class="text-danger" id="captcha-error">{{ __('common.captcha_error') }}</span>
    @enderror 
          </div> 
      <div class="col-md-4">                                   
   @captcha 
          </div> 
</div>
                            <p class="mt-6 text-sm leading-7 text-on-surface-variant">{{ __('common.dba_text') }} <img src="{{ url('assets/img/dba.png') }}" alt="G-Fusion" class="dba-img1 inline-block align-middle">.</p>
                            <img src="{{ asset('assets/img/payment/payment.png') }}" alt="Payment Cards" class="mt-4 max-w-full">

                            <div class="mt-8">
                                <button type="submit" class="btn-primary w-full justify-center">
                                    {{ __('common.place_order') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>
    




@endsection
@push('styles')
<style>
    .checkout-page .row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        margin: 0 !important;
    }

    .checkout-page .row > [class*="col-"] {
        min-width: 0;
        width: 100%;
        padding: 0 !important;
    }

    .checkout-page .row > .col-md-12,
    .checkout-page .row > .col-12:only-child {
        grid-column: 1 / -1;
    }

    .checkout-page .mb-3,
    .checkout-page .mb-2 {
        margin-bottom: 1rem !important;
    }

    .checkout-page .error,
    .checkout-page .text-danger {
        color: #fca5a5 !important;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: inline-block;
    }

    #delivery-error::before,
    #privacy-error::before,
    #terms-error::before,
    #refund-error::before {
        display: none;
    }

    .checkout-page .checkout-form-card,
    .checkout-page .checkout-summary-card,
    .checkout-page .condtn-info {
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.04);
        border-radius: 1.75rem;
        padding: 1.5rem;
        backdrop-filter: blur(18px);
    }

    .checkout-page .checkout-form-meta {
        margin-bottom: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.03);
        border-radius: 1.25rem;
        padding: 0.95rem 1rem;
    }

    .checkout-page .checkout-form-meta p {
        margin: 0;
        color: rgba(226, 232, 240, 0.8);
        font-size: 0.92rem;
        line-height: 1.7;
    }

    .checkout-page .heading-info,
    .checkout-page label {
        color: #f8fafc;
        display: block;
        margin-bottom: 0.6rem;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .checkout-page .form-control,
    .checkout-page .form-select,
    .checkout-page textarea {
        width: 100%;
        border-radius: 1rem;
        border: 1px solid rgba(153, 247, 255, 0.14);
        background: rgba(7, 10, 20, 0.5);
        color: #f8fafc;
        padding: 0.95rem 1rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .checkout-page input[type="number"] {
        -moz-appearance: textfield;
    }

    .checkout-page input[type="number"]::-webkit-outer-spin-button,
    .checkout-page input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .checkout-page .form-control:focus,
    .checkout-page .form-select:focus,
    .checkout-page textarea:focus {
        border-color: rgba(153, 247, 255, 0.5);
        box-shadow: 0 0 0 3px rgba(153, 247, 255, 0.16);
    }

    .checkout-page .form-control::placeholder,
    .checkout-page textarea::placeholder {
        color: rgba(203, 213, 225, 0.65);
    }

    .checkout-page .custom-select-wrapper {
        position: relative;
    }

    .checkout-page .custom-select-wrapper select {
        appearance: none;
        padding-right: 2.8rem;
    }

    .checkout-page .dropdown-icon,
    .checkout-page .bnicon {
        color: rgba(203, 213, 225, 0.7);
    }

    .checkout-page .dropdown-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .checkout-page .bnicon {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        margin-top: 0.25rem;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.2em;
    }

    .checkout-page .table {
        width: 100%;
        color: #e2e8f0;
        border-collapse: collapse;
    }

    .checkout-page .table th,
    .checkout-page .table td {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        vertical-align: top;
    }

    .checkout-page .table th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: #99f7ff;
    }

    .checkout-page .form-check {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.9rem 0 0;
        margin-bottom: 0.25rem;
    }

    .checkout-page .form-check-input {
        width: 1.1rem;
        height: 1.1rem;
        margin-top: 0.2rem;
        accent-color: #99f7ff;
    }

    .checkout-page .form-check label,
    .checkout-page .form-check a {
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .checkout-page .form-check a {
        color: #99f7ff;
    }

    .checkout-page .form-group.w-100.row {
        margin-top: 1.5rem !important;
        align-items: center;
    }

    .checkout-page .d-flex.position-relative {
        display: grid !important;
        grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
        align-items: center;
        gap: 0.85rem;
    }

    .checkout-page .cardmnth,
    .checkout-page .cardte,
    .checkout-page .cc-cvc {
        text-align: center;
    }

    .checkout-page .checkout-summary-card tr:last-child th,
    .checkout-page .checkout-summary-card tr:last-child td {
        border-bottom: 0;
        padding-bottom: 0;
        font-weight: 800;
        color: #fff3ff;
    }

    .checkout-page .condtn-info img {
        display: block;
        max-width: 100%;
    }

    .checkout-page .condtn-info .captcha img,
    .checkout-page .condtn-info .captcha svg,
    .checkout-page .condtn-info canvas {
        border-radius: 1rem;
    }

    .checkout-page .dba-img1 {
        max-height: 1.75rem;
    }

    @media (max-width: 1279px) {
        .checkout-page section.mt-8 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .checkout-page .row {
            grid-template-columns: 1fr;
        }

        .checkout-page .d-flex.position-relative {
            grid-template-columns: 1fr;
        }

        .checkout-page .bnicon {
            position: static;
            transform: none;
            text-align: center;
            margin: 0;
        }
    }
</style>
@endpush
@push('scripts')
	<script src="{{asset('assets/js/jquery.payment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script>
    
 
    $(document).ready(function() {
        $("#frmCheckout").validate({
			rules: {
				first_name: "required",
                last_name: "required",
                email: {
					required: true,
					email: true
				},
				phone: {
					required: true,
					minlength: 10
				},
				address1: "required",
                post_code:"required",
                city: "required",
                state:"required",
                country: "required",
                terms:"required",
                privacy:"required",
                delivery:"required",
                refund:"required",
                
                captcha:"required",
			},
			messages: {
				first_name: "{{ __('common.name_required') }}",
                last_name: "{{ __('common.name_required') }}",
				phone: {
					required: "{{ __('common.phone_required') }}",
					minlength: "{{ __('common.phone_min') }}"
				},
				address1: "{{ __('common.address_required') }}",
				email: "{{ __('common.email_required') }}",
                post_code:"{{ __('common.post_code_required') }}",
                city:"{{ __('common.city_required') }} ",
                state:"{{ __('common.state_required') }}",
                country: "{{ __('common.country_required') }}",
                terms:"{{ __('common.accept_terms') }}",
                privacy:"{{ __('common.accept_privacy') }}",
                delivery:"{{ __('common.accept_delivery') }}",
                refund:"{{ __('common.accept_refund') }}",
               
                captcha: "{{ __('common.fill_it') }}"
			}
		});
    });
</script>
	<!-- <script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script> -->
	<script>
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
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

	</script>

<script>
    var cardType = '';
    function cardFormValidate() {
        var cardValid = 0;

        $('#card_number').validateCreditCard(function(result) {
            if(result.valid) {
                $("#card-number-error").text('');
                $("#card-month-error").text('');
                $("#card-number-error").fadeOut(300);
                cardValid = 1;
                cardType = result.card_type.name;
                
                
                var cardName = $("#name_on_card").val();
                var expMonth = $("#expiry_month").val();
                var expYear = $("#expiry_year").val();
                var cvv = $("#cvv").val();
                
                var regName = /^[a-z ,.'-]+$/i;
                var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
                var regYear = /^2024|2025|2026|2027|2028|2029|2030|2031|2032|2033|2034|2035|2036|2037|2038|2039|2040|2041|2042|2043|2044|2045|2046|2047|2048|2049|2050$/;
                var regCVV = /^[0-9]{3,4}$/;
                
                if (!regMonth.test(expMonth)) {
                    $("#card-number-error").text('');
                    $("#card-number-error").fadeOut(300);
                    $("#card-month-error").text('Invalid Card Expiry Month');
                    $("#expiry_month").focus();
                    cardValid = 0;
                }
                else if (!regYear.test(expYear)) {    
                    $("#card-number-error").text('');
                    $("#card-number-error").fadeOut(300);
                    $("#card-month-error").text('Invalid Card Expiry Year');
                    $("#expiry_month").focus();
                    cardValid = 0;
                }
                else if (!regCVV.test(cvv)) {	
                    $("#card-number-error").text('');
                    $("#card-number-error").fadeOut(300);
                    $("#card-month-error").text('');
                    $("#card-cvv-error").text('Invalid CVC');
                    $("#cvv").focus();
                    cardValid = 0;
                }
                else if (!regName.test(cardName)) {
                    $("#card-number-error").text('');
                    $("#card-number-error").fadeOut(300);
                    $("#card-month-error").text('');
                    $("#card-cvv-error").text('');
                    $("#card-name-error").text('Invalid Card Holder Name');
                    $("#name_on_card").focus();
                    cardValid = 0;
                }
        
        
        
        
            }
            else {
                $("#card-number-error").text('Card Number is invalid');
                $("#card-number-error").css("display", "inline-block");
                cardValid = 0;
            }
        });
        
        
        switch(cardType) {
        
        case 'Visa':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-visa');
            break;
            
        case 'Amex':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-amex');
            break;
        
        case 'diners_club_carte_blanche':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-diners-club');
            break;    
        
        case 'diners_club_international':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-diners-club');
            break;    
        
        case 'jcb':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-jcb');
            break;    
        
        case 'laser':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-credit-card');
            break;    
        
        case 'visa_electron':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-visa');
            break;
        
        case 'MasterCard':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-mastercard');
            break;    
        
        case 'Maestro':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-mastercard');
            break;
        
        case 'Discover':
            $('#card-icon').removeClass('fa-credit-card').addClass('fa-cc-discover');
            break;
        }
        
        return cardValid;
    }
    $(document).ready(function() {
        //card validation on input fields
    $('#button-confirm').on('click', function() {
            $("#overlay").fadeIn(300);
            if(cardFormValidate()) {
                var cardNumber = $("#card_number").val();
                var cardName = $("#name_on_card").val();
                var expMonth = $("#expiry_month").val();
                var expYear = $("#expiry_year").val();
                var cvv = $("#cvv").val();
                $.ajax({
                    //url: 'index.php?route=extension/payment/dasgateway/cc_payment',
                    url: '{{route("cart.payment")}}',
                    type: 'post',
                    data: {'card_number':cardNumber, 'name':cardName, 'expiry_month':expMonth, 'expiry_year':expYear, 'cvv':cvv, 'card_type': cardType, '_token': token},
                    dataType: 'json',
                    cache: false,
                    beforeSend: function() {
                        $('#button-confirm').button('loading');
                    },
                    complete: function() {
                        $('#button-confirm').button('reset');
                        $("#overlay").fadeOut(300);
                    },
                    success: function(json) {
                        
                        if (json['error']) {
                            //$('form').hide();
                            //$('#continue').click();
                            $('#payment-error').text(json['error']);
                            $("#overlay").fadeOut(300);
                        }
        
                        if (json['redirect']) {
                            $("#overlay").fadeOut(300);
                            location = json['redirect'];					
                        }
                    }
                });
            }
            else {
                $("#overlay").fadeOut(300);
            }
        });
        
        
        
        
    $('[data-numeric]').payment('restrictNumeric');
    $('.cc-number').payment('formatCardNumber');
    $('.cc-exp').payment('formatCardExpiry');
    $('.cc-cvc').payment('formatCardCVC');
    $.fn.toggleInputError = function(erred) {
        this.parent('.form-group').toggleClass('has-error', erred);
        return this;
    };
        
    });

    (function() {
    var $,
        __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

    $ = jQuery;

    $.fn.validateCreditCard = function(callback, options) {
        var bind, card, card_type, card_types, get_card_type, is_valid_length, is_valid_luhn, normalize, validate, validate_number, _i, _len, _ref;
        card_types = [
        {
            name: 'Amex',
            pattern: /^3[47]/,
            valid_length: [15]
        }, {
            name: 'diners_club_carte_blanche',
            pattern: /^30[0-5]/,
            valid_length: [14]
        }, {
            name: 'diners_club_international',
            pattern: /^36/,
            valid_length: [14]
        }, {
            name: 'jcb',
            pattern: /^35(2[89]|[3-8][0-9])/,
            valid_length: [16]
        }, {
            name: 'laser',
            pattern: /^(6304|670[69]|6771)/,
            valid_length: [16, 17, 18, 19]
        }, {
            name: 'visa_electron',
            pattern: /^(4026|417500|4508|4844|491(3|7))/,
            valid_length: [16]
        }, {
            name: 'Visa',
            pattern: /^4/,
            valid_length: [16]
        }, {
            name: 'MasterCard',
            pattern: /^5[1-5]/,
            valid_length: [16]
        }, {
            name: 'Maestro',
            pattern: /^(5018|5020|5038|6304|6759|676[1-3])/,
            valid_length: [12, 13, 14, 15, 16, 17, 18, 19]
        }, {
            name: 'Discover',
            pattern: /^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,
            valid_length: [16]
        }
        ];
        bind = false;
        if (callback) {
        if (typeof callback === 'object') {
            options = callback;
            bind = false;
            callback = null;
        } else if (typeof callback === 'function') {
            bind = true;
        }
        }
        if (options == null) {
        options = {};
        }
        if (options.accept == null) {
        options.accept = (function() {
            var _i, _len, _results;
            _results = [];
            for (_i = 0, _len = card_types.length; _i < _len; _i++) {
            card = card_types[_i];
            _results.push(card.name);
            }
            return _results;
        })();
        }
        _ref = options.accept;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        card_type = _ref[_i];
        if (__indexOf.call((function() {
            var _j, _len1, _results;
            _results = [];
            for (_j = 0, _len1 = card_types.length; _j < _len1; _j++) {
            card = card_types[_j];
            _results.push(card.name);
            }
            return _results;
        })(), card_type) < 0) {
            throw "Credit card type '" + card_type + "' is not supported";
        }
        }
        get_card_type = function(number) {
        var _j, _len1, _ref1;
        _ref1 = (function() {
            var _k, _len1, _ref1, _results;
            _results = [];
            for (_k = 0, _len1 = card_types.length; _k < _len1; _k++) {
            card = card_types[_k];
            if (_ref1 = card.name, __indexOf.call(options.accept, _ref1) >= 0) {
                _results.push(card);
            }
            }
            return _results;
        })();
        for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
            card_type = _ref1[_j];
            if (number.match(card_type.pattern)) {
            return card_type;
            }
        }
        return null;
        };
        is_valid_luhn = function(number) {
        var digit, n, sum, _j, _len1, _ref1;
        sum = 0;
        _ref1 = number.split('').reverse();
        for (n = _j = 0, _len1 = _ref1.length; _j < _len1; n = ++_j) {
            digit = _ref1[n];
            digit = +digit;
            if (n % 2) {
            digit *= 2;
            if (digit < 10) {
                sum += digit;
            } else {
                sum += digit - 9;
            }
            } else {
            sum += digit;
            }
        }
        return sum % 10 === 0;
        };
        is_valid_length = function(number, card_type) {
        var _ref1;
        return _ref1 = number.length, __indexOf.call(card_type.valid_length, _ref1) >= 0;
        };
        validate_number = (function(_this) {
        return function(number) {
            var length_valid, luhn_valid;
            card_type = get_card_type(number);
            luhn_valid = false;
            length_valid = false;
            if (card_type != null) {
            luhn_valid = is_valid_luhn(number);
            length_valid = is_valid_length(number, card_type);
            }
            return {
            card_type: card_type,
            valid: luhn_valid && length_valid,
            luhn_valid: luhn_valid,
            length_valid: length_valid
            };
        };
        })(this);
        validate = (function(_this) {
        return function() {
            var number;
            number = normalize($(_this).val());
            return validate_number(number);
        };
        })(this);
        normalize = function(number) {
        return number.replace(/[ -]/g, '');
        };
        if (!bind) {
        return validate();
        }
        this.on('input.jccv', (function(_this) {
        return function() {
            $(_this).off('keyup.jccv');
            return callback.call(_this, validate());
        };
        })(this));
        this.on('keyup.jccv', (function(_this) {
        return function() {
            return callback.call(_this, validate());
        };
        })(this));
        callback.call(this, validate());
        return this;
    };

    }).call(this);


    </script>

@endpush
