@extends('frontend.layouts.master')

@section('title', __('common.contact') . ' | EliteLift Gaming')
@section('meta_description', 'Contact EliteLift Gaming for support, order questions, and service guidance.')

@section('main-content')
@php
    $settings = DB::table('settings')->get();
@endphp

<main class="pb-20 pt-6 sm:pt-10">
    <section class="page-container">
        <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-surface/85 shadow-soft">
            <div class="hero-orb left-[-5rem] top-[-4rem] h-48 w-48 bg-primary/20"></div>
            <div class="hero-orb bottom-[-5rem] right-[-3rem] h-60 w-60 bg-secondary/20"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,120,42,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(255,196,120,0.12),transparent_28%)]"></div>

            <div class="relative z-10 grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1.05fr_0.95fr] lg:px-12 lg:py-12">
                <div class="flex flex-col justify-between">
                    <div>
                        <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-primary">
                            <span class="h-2 w-2 rounded-full bg-primary shadow-[0_0_18px_rgba(255,120,42,0.9)]"></span>
                            {{ __('common.contact_stage_label') }}
                        </div>

                        <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-[-0.04em] text-on-surface sm:text-5xl lg:text-6xl">
                            {{ __('common.contact_title') }}
                        </h1>
                        <p class="mt-5 max-w-2xl text-sm leading-7 text-on-surface-variant sm:text-base">
                            {{ __('common.contact_intro') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.contact') }}
                            </span>
                        </div>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                            <a href="{{ route('product-lists') }}" class="btn-primary">{{ __('common.our_games') }}</a>
                            <a href="{{ route('pages', 'about-us') }}" class="btn-ghost">{{ __('common.about') }}</a>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.contact_metric_window_label') }}</p>
                            <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.contact_metric_window_value') }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.contact_metric_topics_label') }}</p>
                            <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.contact_metric_topics_value') }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.contact_metric_path_label') }}</p>
                            <p class="mt-3 text-base font-semibold text-on-surface">{{ __('common.contact_metric_path_value') }}</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel border-white/10 bg-black/30 p-6 sm:p-8">
                    <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">{{ __('common.contact_panel_label') }}</p>
                    <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">{{ __('common.contact_panel_title') }}</h2>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                        {{ __('common.contact_panel_text') }}
                    </p>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.company_info') }}</p>
                            <p class="mt-3 text-base leading-7 text-on-surface">{{ __('common.company_name') }}</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.email') }}</p>
                            <p class="mt-3 break-words text-base leading-7 text-on-surface">{{ __('common.company_email') }}</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
                        <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.address') }}</p>
                        <p class="mt-3 text-base leading-7 text-on-surface-variant">{{ __('common.company_address') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-container mt-8 grid gap-8 lg:grid-cols-[0.84fr_1.16fr]">
        <div class="space-y-5">
            <div class="glass-panel p-6 sm:p-8">
                <span class="section-label">{{ __('common.contact_info_label') }}</span>
                <h2 class="font-headline text-3xl font-black text-on-surface sm:text-4xl">{{ __('common.contact_info_title') }}</h2>
                <p class="mt-5 text-base leading-8 text-on-surface-variant">{{ __('common.contact_info_text') }}</p>
                <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ __('common.query_note') }}</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-1">
                <div class="feature-card">
                    <span class="material-symbols-outlined text-4xl text-primary">schedule</span>
                    <h3 class="mt-4 font-headline text-xl font-bold text-on-surface">{{ __('common.contact_card_window_title') }}</h3>
                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ __('common.query_note') }}</p>
                </div>

                <div class="feature-card">
                    <span class="material-symbols-outlined text-4xl text-primary">verified_user</span>
                    <h3 class="mt-4 font-headline text-xl font-bold text-on-surface">{{ __('common.contact_card_trust_title') }}</h3>
                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ __('common.contact_card_trust_text') }}</p>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6 sm:p-8">
            <span class="section-label">{{ __('common.write_message') }}</span>
            <h2 class="font-headline text-3xl font-black text-on-surface sm:text-4xl">{{ __('common.contact_form_title') }}</h2>
            <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ __('common.contact_form_text') }}</p>

            <form method="POST" action="{{ route('contact.send') }}" id="contactForm" class="mt-8 space-y-5">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.name') }}</label>
                        <input type="text" id="name" name="name" required="required" placeholder="{{ __('common.name') }}" class="topup-input">
                    </div>

                    <div>
                        <label for="email" class="mb-2 block font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.email') }}</label>
                        <input type="email" id="email" name="email" required placeholder="{{ __('common.email') }}" class="topup-input">
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-2 block font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.phone') }}</label>
                        <input type="number" id="phone" name="phone" required placeholder="{{ __('common.phone') }}" class="topup-input">
                    </div>

                    <div>
                        <label for="subject" class="mb-2 block font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.your_subject') }}</label>
                        <input type="text" id="subject" name="subject" required placeholder="{{ __('common.your_subject') }}" class="topup-input">
                    </div>
                </div>

                <div>
                    <label for="message" class="mb-2 block font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.your_message') }}</label>
                    <textarea name="message" rows="8" id="message" placeholder="{{ __('common.enter_message') }}" required class="topup-input min-h-[200px] resize-y"></textarea>
                </div>

                <div class="grid gap-5 md:grid-cols-[1fr_auto] md:items-end">
                    <div>
                        <label for="captcha" class="mb-2 block font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.fill_captcha') }}</label>
                        <input type="text" id="captcha" name="captcha" autocomplete="off" placeholder="{{ __('common.fill_captcha') }}" required class="topup-input">
                        @error('captcha')
                            <span class="mt-2 block text-sm text-error" id="captcha-error">{{ __('common.captcha_error') }}</span>
                        @enderror
                    </div>

                    <div class="rounded-[1.4rem] border border-white/10 bg-black/20 p-4">
                        @captcha
                    </div>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm leading-7 text-on-surface-variant">
                        {{ __('common.contact_form_note') }}
                    </p>

                    <button name="submit" type="submit" id="submit" class="btn-primary">{{ __('common.send_message') }}</button>
                </div>
            </form>

            <p class="form-message"></p>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    .error {
        color: #ff716c;
        display: block;
        font-size: 0.875rem;
        margin-top: 0.5rem;
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
                message: "required",
                captcha: "required",
            },
            messages: {
                name: "{{ __('common.name_required') }}",
                subject: "{{ __('common.subject_required') }}",
                email: "{{ __('common.email_required') }}",
                phone: {
                    required: "{{ __('common.phone_required') }}",
                    minlength: "{{ __('common.phone_min') }}"
                },
                message: "{{ __('common.message_required') }}",
                captcha: "{{ __('common.fill_it') }}"
            }
        });
    });
</script>

<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush
