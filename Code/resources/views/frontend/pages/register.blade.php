@extends('frontend.layouts.master')

@section('title', 'Register Page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-surface/85 shadow-soft">
                <div class="hero-orb left-[-5rem] top-[-4rem] h-48 w-48 bg-primary/20"></div>
                <div class="hero-orb bottom-[-5rem] right-[-3rem] h-60 w-60 bg-secondary/20"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,120,42,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(255,196,120,0.12),transparent_28%)]"></div>

                <div class="relative z-10 grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1.02fr_0.98fr] lg:px-12 lg:py-12">
                    <div class="flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-primary">
                                <span class="h-2 w-2 rounded-full bg-primary shadow-[0_0_18px_rgba(255,120,42,0.9)]"></span>
                                {{ __('common.auth_new_player') }}
                            </div>

                            <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-[-0.04em] text-on-surface sm:text-5xl lg:text-6xl">
                                {{ __('common.auth_register_title') }}
                            </h1>
                            <p class="mt-5 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                                {{ __('common.auth_register_intro') }}
                            </p>

                            <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                                <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                    {{ __('common.home') }}
                                </a>
                                <span>/</span>
                                <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                    {{ __('common.registeration') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.auth_metric_access_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.auth_metric_access_value') }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.auth_metric_captcha_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.auth_metric_captcha_value') }}</p>
                            </div>
                            <div class="metric-card">
                                <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.auth_metric_progress_label') }}</p>
                                <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.auth_metric_progress_value') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/30 p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4 border-b border-white/10 pb-6">
                            <div>
                                <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.registeration') }}</p>
                                <h2 class="mt-3 text-3xl font-black tracking-tight text-on-surface">{{ __('common.auth_register_panel_title') }}</h2>
                            </div>
                            <div class="rounded-full border border-primary/20 bg-primary/10 px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.22em] text-primary">
                                ELG
                            </div>
                        </div>

                        <form name="frmRegister" id="frmRegister" action="{{ route('register.submit') }}" method="post" class="mt-8 space-y-5 form">
                            @csrf

                            <div>
                                <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-on-surface-muted">
                                    {{ __('common.name') }}
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="{{ __('common.name') }}" class="topup-input">
                                @error('name')
                                    <span class="mt-2 inline-block text-sm text-error" id="name-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-on-surface-muted">
                                    {{ __('common.email') }}
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="{{ __('common.email') }}" class="topup-input">
                                @error('email')
                                    <span class="mt-2 inline-block text-sm text-error" id="email-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-on-surface-muted">
                                        {{ __('common.password') }}
                                    </label>
                                    <input type="password" name="password" class="topup-input" id="password" required placeholder="{{ __('common.password') }}">
                                    @error('password')
                                        <span class="mt-2 inline-block text-sm text-error" id="password-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-on-surface-muted">
                                        {{ __('common.confirm_password') }}
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('common.confirm_password') }}" class="topup-input">
                                </div>
                            </div>

                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                <div class="grid gap-4 sm:grid-cols-[1fr_auto] sm:items-end">
                                    <div>
                                        <label for="captcha" class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-on-surface-muted">
                                            {{ __('common.fill_captcha') }}
                                        </label>
                                        <input type="text" id="captcha" name="captcha" autocomplete="off" placeholder="{{ __('common.fill_captcha') }}" required class="topup-input">
                                        @error('captcha')
                                            <span class="mt-2 inline-block text-sm text-error" id="captcha-error">{{ __('common.captcha_error') }}</span>
                                        @enderror
                                    </div>
                                    <div class="overflow-hidden rounded-2xl border border-white/10 bg-black/20 px-3 py-3">
                                        @captcha
                                    </div>
                                </div>
                            </div>

                            <label for="agre-condtn" class="flex items-start gap-3 rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm leading-7 text-on-surface-variant">
                                <input class="mt-1 h-5 w-5 rounded border-white/20 bg-transparent text-primary" name="terms" type="checkbox" value="" id="agre-condtn" required>
                                <span>
                                    {{ __('common.terms_agreement') }}
                                    <a href="{{ route('pages', 'terms-conditions') }}" class="ml-1 font-semibold text-primary transition hover:text-white">
                                        {{ __('common.terms_policy') }}
                                    </a>
                                </span>
                            </label>

                            <div class="rounded-[1.4rem] border border-white/10 bg-white/5 px-4 py-4 text-sm leading-7 text-on-surface-variant">
                                {{ __('common.auth_register_note') }}
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn-primary w-full justify-center">
                                    {{ __('common.register') }}
                                </button>
                            </div>
                        </form>

                        <div class="mt-6 rounded-[1.5rem] border border-white/10 bg-white/5 px-5 py-4 text-center text-sm text-on-surface-variant">
                            {{ __('common.existing_account') }}
                            <a href="{{ route('login.form') }}" class="font-semibold text-primary transition hover:text-white">
                                {{ __('common.log_in') }}
                            </a>
                        </div>
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
            $("#frmRegister").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 5
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    terms: "required",
                    captcha: "required",
                },
                messages: {
                    name: "{{ __('common.name_required') }}",
                    password: {
                        required: "{{ __('common.password_required') }}",
                        minlength: "{{ __('common.password_min') }}"
                    },
                    password_confirmation: {
                        required: "{{ __('common.password_confirmation_required') }}",
                        minlength: "{{ __('common.password_confirmation_min') }}",
                        equalTo: "{{ __('common.password_confirmation_equal') }}"
                    },
                    email: "{{ __('common.email_required') }}",
                    terms: "{{ __('common.terms_required') }}",
                    captcha: "{{ __('common.fill_it') }}"
                },
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        #frmRegister label.error {
            color: #fca5a5;
            display: inline-block;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    </style>
@endpush
