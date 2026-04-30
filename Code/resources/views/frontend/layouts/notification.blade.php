<div class="fixed inset-x-0 top-24 z-[70] mx-auto w-full max-w-3xl px-4">
    @if(session('success'))
        <div
            x-data="{ open: true }"
            x-init="setTimeout(() => open = false, 4500)"
            x-show="open"
            x-transition.opacity.duration.400ms
            class="flash-alert border-success/30 bg-success/10 text-on-surface"
            role="alert"
        >
            <span class="material-symbols-outlined text-success">check_circle</span>
            <div class="flex-1">{{ session('success') }}</div>
            <button type="button" class="text-on-surface-variant transition hover:text-on-surface" @click="open = false" aria-label="Close">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div
            x-data="{ open: true }"
            x-init="setTimeout(() => open = false, 5000)"
            x-show="open"
            x-transition.opacity.duration.400ms
            class="flash-alert border-error/30 bg-error/10 text-on-surface"
            role="alert"
        >
            <span class="material-symbols-outlined text-error">error</span>
            <div class="flex-1">{{ session('error') }}</div>
            <button type="button" class="text-on-surface-variant transition hover:text-on-surface" @click="open = false" aria-label="Close">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    @endif
</div>
