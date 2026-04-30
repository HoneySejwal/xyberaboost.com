@extends('user.layouts.master')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.password_stage_label') }}</span>
                        <h1 class="section-title">{{ __('common.password_title') }}</h1>
                        <p class="section-copy mt-6">
                            {{ __('common.password_intro') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.change_password') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.password_metric_route_label') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.password_metric_route_value') }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.password_metric_fields_label') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ __('common.password_metric_fields_value') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="mx-auto max-w-3xl">
                <div class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">{{ __('common.password_panel_label') }}</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.password_panel_title') }}</h2>
                    </div>

                    <p class="mt-8 text-sm leading-7 text-on-surface-variant sm:text-base">
                        {{ __('common.password_panel_intro') }}
                    </p>

                    <form method="POST" action="{{ route('change.password') }}" class="mt-8 space-y-5">
                        @csrf

                        @foreach ($errors->all() as $error)
                            <div class="rounded-[1.25rem] border border-error/30 bg-error/10 px-4 py-3 text-sm text-on-surface">
                                {{ $error }}
                            </div>
                        @endforeach

                        <div>
                            <label for="password" class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.old_password') }}</label>
                            <input id="password" type="password" class="topup-input" name="current_password" autocomplete="current-password">
                        </div>

                        <div>
                            <label for="new_password" class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.new_password') }}</label>
                            <input id="new_password" type="password" class="topup-input" name="new_password" autocomplete="current-password">
                        </div>

                        <div>
                            <label for="new_confirm_password" class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.new_password_confirm') }}</label>
                            <input id="new_confirm_password" type="password" class="topup-input" name="new_confirm_password" autocomplete="current-password">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                {{ __('common.password_update_button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
