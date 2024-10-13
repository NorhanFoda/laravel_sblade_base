<!DOCTYPE html>
<html
    @if(app()->getLocale()=='ar')
        lang="ar" dir="rtl"
    @else
        lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @endif
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('UI/assets/v1/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{asset('UI/assets/v1/img/favicon.png')}}">
    <title>{{config('app.name')}} | @yield('title')</title>
    @include('dashboard.layouts.styles')
    @stack('css')
</head>
<body class="g-sidenav-show bg-gray-200  @if(app()->getLocale()=='ar')  rtl @endif">
<!-- Sidebar -->
@include('dashboard.layouts.sidebar')
<!-- End of Sidebar -->
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-x-hidden">
    <!-- Topbar -->
    @include('dashboard.layouts.topbar')
    <!-- End of Top bar -->
    <div class="container-fluid py-4">
        @yield('content')
        <!-- Footer -->
        @include('dashboard.layouts.footer')
        <!-- End of Footer -->
    </div>
</main>
@include('dashboard.layouts.style-settings')
{{-- @vite(['resources/js/app.js']) --}}
@include('dashboard.layouts.scripts')
@stack('js')
</body>
</html>
