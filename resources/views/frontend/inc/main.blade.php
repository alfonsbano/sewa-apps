<!DOCTYPE html>
<html lang="en">
<head>
    @yield('title')

    {{-- link CSS global --}}
    @include('frontend.inc.links')

    {{-- slot CSS tambahan per‑halaman --}}
    @yield('link')
    @yield('css')

    {{-- <link rel="shortcut icon" href="/img/logo.png"> --}}

    <style>
        .availability-form{ margin-top:-50px; position:relative; z-index:2; }

        .bg-custom, .btn-custom { background-color:#17b2ea; }
        .btn-custom:hover      { background-color:#08bfbf; }

        .swiper-slide img      { width:100%; height:auto; object-fit:cover; object-position:center; }

        @media (max-width:575px){
            .availability-form{ margin-top:25px; padding:0 35px; }
            .swiper-slide img { height:50vh; }
        }

        .pop:hover{
            border-top-color:var(--teal)!important;
            transform:scale(1.03);
            transition:all .3s;
        }

        .navbar{
            background-color:rgb(23, 192, 234);
            transition:background-color .3s ease;
        }
        .navbar.scrolled{ background-color:rgba(23, 143, 234, 0.8); }

        .box{ border-top-color:var(--teal)!important; }
    </style>
</head>
<body>

    {{-- HEADER & NAVBAR --}}
    @include('frontend.inc.header')

    {{-- MODAL / LOGOUT --}}
    @include('frontend.inc.logout')

    {{-- KONTEN UTAMA --}}
    @yield('content')

    <hr class="mt-4">

    {{-- FOOTER --}}
    <section class="bg-custom footer-index" id="footer-index">
        @include('frontend.inc.footer')
    </section>

    {{-- SWEETALERT --}}
    @include('vendor.sweetalert.alert')

    {{-- SCRIPT GLOBAL (Bootstrap, jQuery, dll) --}}
    <section class="script" id="script">
        @include('frontend.inc.scripts')
    </section>

    {{-- SCRIPT KHUSUS PER‑HALAMAN (mis. FullCalendar) --}}
    @yield('scripts')

</body>
</html>
