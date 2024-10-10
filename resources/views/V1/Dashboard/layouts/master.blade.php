<!--
=========================================================
* Material Dashboard 2 - v3.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('UI/assets/v1/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{asset('UI/assets/v1/img/favicon.png')}}">

    <title>{{config('app.name')}}</title>

    @include('V1.Dashboard.layouts.styles')


    @stack('css')

</head>

<body class="g-sidenav-show bg-gray-200">

    <!-- Sidebar -->
    @include('V1.Dashboard.layouts.sidebar')
    <!-- End of Sidebar -->

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <!-- Topbar -->
        @include('V1.Dashboard.layouts.topbar')
        <!-- End of Topbar -->

        <div class="container-fluid py-4">

            @yield('content')

            <!-- Footer -->
            @include('V1.Dashboard.layouts.footer')
            <!-- End of Footer -->

        </div>
    </main>

    @include('V1.Dashboard.layouts.style-settings')

    {{-- @vite(['resources/js/app.js']) --}}

    @include('V1.Dashboard.layouts.scripts')
    @stack('js')
</body>

</html>
