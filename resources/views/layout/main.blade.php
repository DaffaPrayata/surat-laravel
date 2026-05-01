<!DOCTYPE html>
<html
    lang="id"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('sneat/') }}/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ config('app.name') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('logo-black.png') }}"/>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />

    <link rel="stylesheet" href="{{asset('sneat/vendor/fonts/boxicons.css')}}"/>
    <link rel="stylesheet" class="template-customizer-core-css" href="{{asset('sneat/vendor/css/core.css')}}"/>
    <link rel="stylesheet" class="template-customizer-theme-css" href="{{asset('sneat/vendor/css/theme-default.css')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/css/demo.css')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/vendor/libs/sweetalert2/sweetalert2.min.css')}}"/>

    @stack('style')

    <style>
        /* ── MOD MODERN INDUSTRIAL: MEMPERPANJANG AREA DASHBOARD ── */

        /* 1. Reset Navbar agar tidak memotong Dashboard */
        .layout-navbar {
            position: relative !important; /* Bikin navbar gak melayang nutupin konten */
            width: 100% !important;
            margin: 0 !important;
            padding: 0.5rem 1.5rem !important;
            box-shadow: none !important;
            background: transparent !important; /* Biar nyatu sama dashboard */
        }

        /* 2. Memperpanjang Dashboard ke Atas */
        .layout-page {
            padding-top: 0 !important; /* Hapus padding yang bikin sempit */
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            margin-top: -20px; /* Tarik dashboard sedikit ke atas biar lebih luas */
        }

        .container-p-y {
            padding-top: 0.5rem !important; /* Pepetin konten ke arah navbar */
        }

        /* 3. Perbaikan Mobile Overlay */
        @media (max-width: 1199.98px) {
            .layout-menu {
                position: fixed !important;
                z-index: 1500 !important;
                transform: translate3d(-100%, 0, 0);
                transition: transform 0.3s ease-in-out;
            }

            .layout-menu-expanded .layout-menu {
                transform: translate3d(0, 0, 0) !important;
            }

            .layout-overlay {
                z-index: 1400 !important;
            }

            /* Di mobile navbar tetep dibikin clean */
            .layout-navbar {
                background: #111 !important; /* Kasih warna solid dikit di mobile */
                margin-bottom: 10px !important;
            }
        }

        /* Style tambahan biar toggle gak ketutup */
        .nav-item {
            z-index: 1200 !important;
        }
    </style>

    <script src="{{ asset('sneat/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('sneat/js/config.js') }}"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            @include('components.sidebar')

            <div class="layout-page">
                
                @include('components.navbar')

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>

                    @include('components.footer')
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="{{ asset('sneat/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('sneat/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('sneat/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('sneat/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('sneat/vendor/js/menu.js')}}"></script>
    <script src="{{ asset('sneat/vendor/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('sneat/js/main.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.layout-menu-toggle').on('click', function (e) {
                e.preventDefault();
                $('html').toggleClass('layout-menu-expanded');
            });
            $('.layout-overlay').on('click', function () {
                $('html').removeClass('layout-menu-expanded');
            });
        });
    </script>

    @stack('script')
</body>
</html>