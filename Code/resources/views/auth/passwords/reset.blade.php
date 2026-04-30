@extends('frontend.layouts.master')

@section('main-content')
 <section class="pageheader-section">
		<div class="container">
            <div class="section-wrapper text-center text-uppercase">
                <h2 class="pageheader-title">{{ __('common.reset_password') }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                      <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __('common.home') }}  <span class="ficon"> /  </span></a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ __('common.reset_password') }}</li>
                    </ol>
                </nav>
            </div>
		</div>
   </section>
 <!-- Login Section Section Starts Here -->
    <div class="login-section padding-top padding-bottom">
        <div class=" container">
            <div class="account-wrapper">
                <h3 class="title">{{ __('common.reset_password') }}</h3>
                <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group text-start mb-2">
                            <label for="email" class="mb-2">{{ __('E-Mail Address') }}</label>
                            
                                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                     

                        <div class="form-group text-start mb-2">
                            <label for="password" class="mb-2">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                      

                        <div class="form-group text-start mb-2">
                            <label for="password-confirm" class="mb-2">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group">                           
                                <button type="submit" class="default-button colorbtn1">
                                    {{ __('Reset Password') }}
                                </button>                            
                        </div>
                    </form>               
                <div class="account-bottom mt-3">
                    <span class="d-block cate pt-10">{{ __('common.dont_have_account') }} <a href="{{ route('register.form') }}"> {{ __('common.sign_up') }}</a></span>
               </div>
            </div>
        </div>
    </div>
    </main>

@endsection



