@php
    $viteManifestPath = public_path('build/manifest.json');
@endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="EliteLift Gaming user dashboard">
    <meta name="author" content="EliteLift Gaming">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EliteLift Gaming | Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@0..1" rel="stylesheet">
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    @if(file_exists($viteManifestPath))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            color-scheme: dark;
        }

        * {
            box-sizing: border-box;
        }

        body#page-top {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(255, 120, 42, 0.16), transparent 26%),
                radial-gradient(circle at bottom right, rgba(255, 196, 120, 0.12), transparent 22%),
                linear-gradient(180deg, #0c1220 0%, #090f1a 45%, #070b12 100%);
            color: #f8fafc;
            font-family: 'Oxanium', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .dashboard-shell {
            display: grid;
            grid-template-columns: 290px minmax(0, 1fr);
            min-height: 100vh;
        }

        .dashboard-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 1.25rem;
        }

        .dashboard-sidebar-inner,
        .dashboard-topbar,
        .dashboard-card {
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(10, 15, 27, 0.78);
            backdrop-filter: blur(22px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
        }

        .dashboard-sidebar-inner {
            display: flex;
            height: 100%;
            flex-direction: column;
            gap: 1.25rem;
            border-radius: 1.75rem;
            padding: 1.25rem;
        }

        .dashboard-main {
            padding: 1.25rem 1.25rem 2rem 0;
        }

        .dashboard-topbar {
            position: sticky;
            top: 1rem;
            z-index: 30;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border-radius: 1.5rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
        }

        .dashboard-content {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .dashboard-brand {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            padding: 0.95rem 1rem;
        }

        .dashboard-brand img {
            width: 3rem;
            height: 3rem;
            object-fit: contain;
        }

        .dashboard-brand-title,
        .dashboard-heading {
            font-family: 'Space Grotesk', sans-serif;
        }

        .dashboard-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .dashboard-nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            border-radius: 1.15rem;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.03);
            color: rgba(226, 232, 240, 0.82);
            padding: 0.95rem 1rem;
            transition: 0.2s ease;
        }

        .dashboard-nav-link:hover,
        .dashboard-nav-link.active {
            border-color: rgba(255, 120, 42, 0.32);
            background: rgba(255, 120, 42, 0.12);
            color: #ffffff;
        }

        .dashboard-nav-link i,
        .dashboard-nav-link .material-symbols-outlined {
            color: #ffb36a;
        }

        .dashboard-small-label {
            color: #ffb36a;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
        }

        .dashboard-topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .dashboard-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.05);
            padding: 0.7rem 1rem;
            color: rgba(226, 232, 240, 0.85);
            font-size: 0.92rem;
        }

        .dashboard-user {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .dashboard-avatar {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 999px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .dashboard-footer {
            border-radius: 1.5rem;
            padding: 1rem 1.25rem;
            text-align: center;
            color: rgba(226, 232, 240, 0.7);
            font-size: 0.9rem;
        }

        .dashboard-mobile-toggle {
            display: none;
        }

        .alert {
            border-radius: 1rem;
        }

        @media (max-width: 1100px) {
            .dashboard-shell {
                grid-template-columns: 1fr;
            }

            .dashboard-sidebar {
                position: static;
                height: auto;
                padding: 1rem 1rem 0;
            }

            .dashboard-sidebar-inner {
                height: auto;
            }

            .dashboard-main {
                padding: 1rem;
            }

            .dashboard-mobile-toggle {
                display: inline-flex;
            }
        }
    </style>
    @stack('styles')
</head>
