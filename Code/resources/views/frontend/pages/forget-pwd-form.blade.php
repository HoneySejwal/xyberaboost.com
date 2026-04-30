@extends('frontend.layouts.master')

@section('title', 'Forget Password')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 grid gap-10 lg:grid-cols-[1fr_0.95fr] lg:items-center">
                    <div>
                        <span class="section-label">{{ __('common.lost_password_text') }}</span>
                        <h1 class="section-title">{{ __('common.lost_password_text') }}</h1>
                        <p class="section-copy mt-6 max-w-2xl">
                            Request a password reset through the existing Laravel password flow and return to your account with the same backend-driven email reset behavior already configured in the application.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.lost_password_text') }}
                            </span>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Reset Flow</p>
                                <p class="mt-3 text-lg font-semibold text-on-surface">Laravel email reset</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Protection</p>
                                <p class="mt-3 text-lg font-semibold text-on-surface">Current page keeps captcha UI</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Access</p>
                                <p class="mt-3 text-lg font-semibold text-on-surface">Back to login after request</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/20 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Recovery Notes</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">Send the reset link safely</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            This page still posts to the existing password email route and keeps the current form behavior in place, including the visible flash messages for success and error states.
                        </p>
                        <div class="mt-6 space-y-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Existing request route preserved: <span class="font-semibold text-on-surface">`/password/email`</span>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Existing entry page preserved: <span class="font-semibold text-on-surface">`/user/forgetpassword`</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="mx-auto max-w-3xl">
                <div class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">{{ __('common.lost_password_text') }}</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.lost_password_text') }}</h2>
                    </div>

                    @if (session('success'))
                        <div class="mt-6 rounded-[1.5rem] border border-success/30 bg-success/10 px-5 py-4 text-sm text-on-surface">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mt-6 rounded-[1.5rem] border border-error/30 bg-error/10 px-5 py-4 text-sm text-on-surface">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form name="frmLogin" id="frmLogin" action="{{ route('password.email') }}" method="post" class="mt-8 space-y-5 form">
                        @csrf

                        <div>
                            <input type="email" name="email" id="email" placeholder="{{ __('common.email') }}" value="{{ old('email') }}" required class="topup-input">
                            @error('email')
                                <span class="mt-2 inline-block text-sm text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid gap-4 rounded-[1.5rem] border border-white/10 bg-white/5 p-4 sm:grid-cols-[1fr_auto] sm:items-center">
                            <div>
                                <input type="text" id="captcha" name="captcha" autocomplete="off" placeholder="{{ __('common.fill_captcha') }}" required class="topup-input">
                                @error('captcha')
                                    <span class="mt-2 inline-block text-sm text-error" id="captcha-error">{{ __('common.captcha_error') }}</span>
                                @enderror
                            </div>
                            <div class="overflow-hidden rounded-2xl border border-white/10 bg-black/20 px-3 py-3">
                                @captcha
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" name="submit" class="btn-primary w-full justify-center">
                                {{ __('common.lost_password_text') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 rounded-[1.5rem] border border-white/10 bg-white/5 px-5 py-4 text-center text-sm text-on-surface-variant">
                        {{ __('common.dont_have_account') }}
                        <a href="{{ route('register.form') }}" class="font-semibold text-primary transition hover:text-white">
                            {{ __('common.sign_up') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $("#frmLogin").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 5
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    captcha: "required",
                },
                messages: {
                    password: {
                        required: "{{ __('common.password_required') }}",
                        minlength: "{{ __('common.password_confirmation_min') }}"
                    },
                    email: "{{ __('common.email_required') }}",
                    captcha: "{{ __('common.fill_it') }}"
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        #frmLogin label.error {
            color: #fca5a5;
            display: inline-block;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    </style>
@endpush
