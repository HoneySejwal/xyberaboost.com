@extends('frontend.layouts.master')
@section('title','Towa-Xports || Contact Us')
@section('main-content')

    <style>
        .error {
            color: #FF0000 !important;
        }
    </style>

	@php
		$settings = DB::table('settings')->get();
	@endphp
    <main>
        <div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb.png') }}');">
            <div class="gt-left-shape">
                <img src="assets/img/shape-1.png" alt="img">
            </div>
            <div class="gt-right-shape">
                <img src="assets/img/shape-2.png" alt="img">
            </div>
            <div class="gt-blur-shape">
                <img src="assets/img/breadcrumb-shape.png" alt="img">
            </div>
            <div class="container">
                <div class="gt-page-heading">
                    <div class="gt-breadcrumb-sub-title">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">  {{ __('common.contact') }} </h1>
                    </div>
                    <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <i class="fa-solid fa-house"></i>
                        </li>
                        <li>
                            <a href="{{route('home')}}">{{ __('common.home') }} :</a>
                        </li>
                        <li class="color">{{ __('common.contact') }}</li>
                    </ul>
                </div>
            </div>
        </div>

         <!-- GT Contact-us Section Start -->
         <section class="gt-contact-us-section section-padding fix">
            <div class="container">
                <div class="gt-contact-us-wrapper">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="gt-comment-form-wrap">
                                <h4>We're Here to Help!</h4>
                                <p></p><strong>Note:</strong> Queries/complaints will be attended within 3 business days.</p>
                                <!--<p>Your email address will not be published. Required fields are marked *</p>-->
                                <form  method="POST" action="{{ route ('contact.send') }}" id="contactForm" class="">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-clt">
                                                <span>Your Name *</span>
                                                <input type="text" placeholder="{{ __('common.enter_name') }}" name="name" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-clt">
                                                <span>Your Phone *</span>
                                                <input type="text" placeholder="{{ __('common.enter_phone') }}" name="phone">
                                                </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-clt">
                                                <span>Subject *</span>
                                                <input type="text" placeholder="{{ __('common.enter_subject') }}" name="subject">
                                                </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-clt">
                                                <span>Your Email *</span>
                                                <input type="email" class="form-control" placeholder="Your Email" name="email">
                                                </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-clt">
                                                <span>Write Message *</span>
                                                <textarea name="message" placeholder="{{ __('common.enter_message') }}"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            
                                            <button name="submit" type="submit" id="submit" class="gt-theme-btn">{{ __('common.send_message') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="gt-contact-bg bg-cover" style="background-image: url(assets/img/inner-page/match-details/bg.jpg);">
                                <div class="gt-contact-content">
                                    <h3>Need Any Help</h3>
                                    <p>Nees Any Help, Call Us  24/7 Full Support</p>
                                    
                                    <div class="gt-contact-item">
                                        <div class="gt-icon">
                                            <i class="fa-regular fa-envelope"></i>
                                        </div>
                                        <ul class="gt-list">
                                            <li><span>Mail Us</span></li>
                                            <li><a href="mailto:{{ __('common.company_email') }}">
                                               {{ __('common.company_email') }}
                                            </a></li>
                                        </ul>
                                    </div>
                                    <div class="gt-contact-item mb-0">
                                        <div class="gt-icon">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <ul class="gt-list">
                                            <li><span>Location:</span></li>
                                            <li>{{ __('common.company_address') }} </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="gt-bg-image">
                                <img src="assets/img/inner-page/contact-bg.jpg" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    
@endsection

@push('styles')
<style>
	.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
	}
    .error {
		color: #FF0000;
	}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $("#contactForm").validate({
            rules: {
                name: "required",
                subject: "required",
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    minlength: 10
                },
                message: "required"
            },
            messages: {
                name: "{{ __('common.name_required') }}",
                subject: "{{ __('common.subject_required') }}",
                email: "{{ __('common.email_required') }}",
                phone: {
                    required: "{{ __('common.phone_required') }}",
                    minlength: "{{ __('common.phone_min') }}"
                },
                message: "{{ __('common.message_required') }}"
            }
        });
    });
</script>

<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush