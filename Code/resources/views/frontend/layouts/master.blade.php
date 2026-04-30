<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;700&display=optional" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=optional" rel="stylesheet">
    @include('frontend.layouts.head')
    @stack('styles')
</head>
<body class="site-shell">
    @include('frontend.layouts.notification')
    @include('frontend.layouts.header')
    <main data-page-content>
        @yield('main-content')
    </main>
    @include('frontend.layouts.footer')
    @stack('scripts')
</body>
</html>
