@extends('user.layouts.master')

@section('title', 'User Profile')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">{{ __('common.profile_stage_label') }}</span>
                        <h1 class="section-title">{{ __('common.profile_title') }}</h1>
                        <p class="section-copy mt-6">
                            {{ __('common.profile_intro') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                {{ __('common.profile_label') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.name') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ $profile->name }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.email') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ $profile->email }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">{{ __('common.profile_metric_role_label') }}</p>
                            <p class="mt-3 text-lg font-semibold text-on-surface">{{ ucfirst($profile->role) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="row">
                <div class="col-md-12">
                    @include('user.layouts.notification')
                </div>
            </div>
        </section>

        <section class="page-container mt-2 grid gap-8 xl:grid-cols-[320px_minmax(0,1fr)]">
            <div class="glass-panel overflow-hidden">
                <div class="profile-banner relative h-40">
                    <img
                        src="{{ $profile->photo ?: asset('backend/img/avatar.png') }}"
                        alt="profile picture"
                        class="profile-avatar absolute left-1/2 top-full h-24 w-24 -translate-x-1/2 -translate-y-1/2 rounded-full border-4 border-[#140f29] object-cover shadow-panel"
                    >
                </div>

                <div class="px-6 pb-8 pt-16 text-center">
                    <h2 class="text-2xl font-black tracking-tight text-on-surface">{{ $profile->name }}</h2>
                    <p class="mt-2 text-sm text-on-surface-variant">{{ $profile->email }}</p>
                    <div class="mt-4 inline-flex rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-primary">
                        {{ $profile->role }}
                    </div>
                </div>
            </div>

            <div class="glass-panel p-6 sm:p-8">
                <div class="border-b border-white/10 pb-6">
                    <span class="section-label">{{ __('common.profile_editor_label') }}</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">{{ __('common.profile_editor_title') }}</h2>
                </div>

                <p class="mt-8 text-sm leading-7 text-on-surface-variant sm:text-base">
                    {{ __('common.profile_editor_intro') }}
                </p>

                <form class="mt-8 space-y-5" method="POST" action="{{ route('user-profile-update', $profile->id) }}">
                    @csrf

                    <div>
                        <label for="inputTitle" class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.name') }}</label>
                        <input id="inputTitle" type="text" name="name" placeholder="{{ __('common.profile_name_placeholder') }}" value="{{ $profile->name }}" class="topup-input">
                        @error('name')
                            <span class="mt-2 inline-block text-sm text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="inputEmail" class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.email') }}</label>
                        <input id="inputEmail" disabled type="email" name="email" placeholder="{{ __('common.profile_email_placeholder') }}" value="{{ $profile->email }}" class="topup-input opacity-70">
                        @error('email')
                            <span class="mt-2 inline-block text-sm text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="inputPhoto" class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.profile_photo_label') }}</label>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn-ghost justify-center">
                                {{ __('common.profile_choose_photo') }}
                            </a>
                            <input id="thumbnail" class="topup-input flex-1" type="text" name="photo" value="{{ $profile->photo }}">
                        </div>
                        @error('photo')
                            <span class="mt-2 inline-block text-sm text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">{{ __('common.profile_metric_role_label') }}</label>
                        <select name="role" class="topup-input">
                            <option value="">{{ __('common.profile_role_placeholder') }}</option>
                            <option value="admin" {{ (($profile->role=='admin') ? 'selected' : '') }}>{{ __('common.admin_label') }}</option>
                            <option value="user" {{ (($profile->role=='user') ? 'selected' : '') }}>{{ __('common.user_label') }}</option>
                        </select>
                        @error('role')
                            <span class="mt-2 inline-block text-sm text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary">{{ __('common.profile_update_button') }}</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection

@push('styles')
    <style>
        .profile-banner {
            background:
                radial-gradient(circle at 20% 20%, rgba(153, 247, 255, 0.18), transparent 28%),
                radial-gradient(circle at 80% 20%, rgba(230, 105, 255, 0.16), transparent 26%),
                linear-gradient(135deg, rgba(15, 11, 34, 0.92), rgba(22, 16, 46, 0.95));
        }
    </style>
@endpush

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
