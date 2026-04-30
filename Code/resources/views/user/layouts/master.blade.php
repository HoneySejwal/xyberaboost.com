<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('user.layouts.head')
<body id="page-top">
    <div class="dashboard-shell" x-data="{ sidebarOpen: window.innerWidth > 1100 }">
        @include('user.layouts.sidebar')
        <div class="dashboard-main">
            @include('user.layouts.header')
            <div class="dashboard-content">
                @yield('main-content')
                @include('user.layouts.footer')
            </div>
        </div>
    </div>
</body>
</html>
