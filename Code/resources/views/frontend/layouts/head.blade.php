@php
    $viteManifestPath = public_path('build/manifest.json');
@endphp
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'EliteLift Gaming | Premium Boosting Services')</title>
<meta name="description" content="@yield('meta_description', 'EliteLift Gaming offers premium boosting services, points top-ups, and secure account support across live game titles.')">
<meta name="keywords" content="@yield('meta_keywords', 'EliteLift Gaming, premium game boosting, points purchase, rank boosting, gaming services')">
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta property="og:title" content="@yield('title', 'EliteLift Gaming | Premium Boosting Services')">
<meta property="og:description" content="@yield('meta_description', 'EliteLift Gaming offers premium boosting services, points top-ups, and secure account support across live game titles.')">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('images/logo.png') }}">
<meta property="og:site_name" content="EliteLift Gaming">
<meta property="og:locale" content="{{ app()->getLocale() === 'ja' ? 'ja_JP' : 'en_US' }}">
@if(file_exists($viteManifestPath))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif
<script async src="https://www.googletagmanager.com/gtag/js?id=G-V2RXVs"></script>
<style>
    html {
        background:
            radial-gradient(circle at 15% 14%, rgba(255, 87, 26, 0.16), transparent 18%),
            radial-gradient(circle at 82% 16%, rgba(255, 138, 0, 0.12), transparent 16%),
            linear-gradient(180deg, #0b0b0b 0%, #131313 48%, #090909 100%);
    }

    body {
        background:
            radial-gradient(circle at 15% 14%, rgba(255, 87, 26, 0.16), transparent 18%),
            radial-gradient(circle at 82% 16%, rgba(255, 138, 0, 0.12), transparent 16%),
            linear-gradient(180deg, #0b0b0b 0%, #131313 48%, #090909 100%);
        color: #e5e2e1;
        margin: 0;
        min-height: 100vh;
        font-family: "Inter", "Segoe UI", system-ui, sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    .site-shell {
        position: relative;
        overflow-x: hidden;
    }

    .page-container {
        width: min(100%, 90rem);
        margin-inline: auto;
        padding-inline: 1rem;
    }

    .glass-panel,
    .glass-nav {
        border: 1px solid rgba(173, 137, 126, 0.18);
        backdrop-filter: blur(20px);
    }

    .glass-panel {
        background: linear-gradient(180deg, rgba(32, 31, 31, 0.82), rgba(19, 19, 19, 0.88));
        border-radius: 0;
        box-shadow: 0 28px 90px rgba(0, 0, 0, 0.42);
    }

    .glass-nav {
        background: linear-gradient(180deg, rgba(19, 19, 19, 0.96), rgba(10, 10, 10, 0.94));
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.28);
    }

    main[data-page-content] {
        opacity: 1;
    }

    .cookiesBtn,
    #cookies-policy .cookiesBtn__link {
        cursor: pointer;
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin: 0;
        overflow: hidden;
        text-align: center;
        text-decoration: none;
        text-overflow: ellipsis;
        transition: opacity .2s ease-out;
        white-space: normal !important;
        width: 100%;
        text-transform: uppercase;
        border: 1px solid rgba(255, 138, 61, 0.42) !important;
        background: linear-gradient(135deg, #ff8a3d 0%, #ff5b1f 100%) !important;
        color: #fff6f1 !important;
        padding: 10px 12px !important;
        border-radius: 6px;
        font-family: 'Space Grotesk', sans-serif !important;
    }

    #cookies-policy .cookies__alert {
        border: 1px solid rgba(255, 255, 255, 0.16) !important;
        background: linear-gradient(180deg, rgba(15, 18, 25, 0.98) 0%, rgba(10, 12, 18, 0.96) 100%) !important;
        color: #f5f7fb !important;
        backdrop-filter: blur(20px);
    }

    #cookies-policy .cookies__title {
        color: #f5f7fb !important;
        text-align: center;
        font-size: 16px;
    }

    .vite-preview-notice {
        padding: 10px 14px;
        background: rgba(255, 190, 100, 0.12);
        border: 1px solid rgba(255, 190, 100, 0.35);
        color: #ffd36f;
        font: 600 13px/1.4 "Oxanium", sans-serif;
        text-align: center;
    }

    @media (min-width: 640px) {
        .page-container {
            padding-inline: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .page-container {
            padding-inline: 2rem;
        }
    }
</style>
@cookieconsentscripts
@cookieconsentview
