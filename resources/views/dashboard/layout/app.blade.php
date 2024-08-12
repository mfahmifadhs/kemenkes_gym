<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Kemenkes Bootcamp">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kemenkes Bootcamp & Fitness Center</title>
    <link rel="icon" href="{{ asset('dist/img/icon-kemenkes.png') }}" type="image/x-icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/flaticon.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/owl.carousel.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/barfiller.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/admin/css/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/select2.css') }}">
    @yield('css')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                <!-- <li><a href="{{ route('dashboard') }}"><i class="fa fa-heartbeat"></i> Classes</a></li> -->
                <!-- <li><a href="{{ route('dashboard') }}"><i class="fa fa-pie-chart"></i> Survey Result</a></li> -->
                <li>
                    <a href="{{ route('jadwal.show') }}"><i class="fa fa-calendar"></i> Schedule</a>
                </li>

                <!-- <li><a href="{{ route('leaderboard') }}"><i class="fa fa-bar-chart"></i> Leaderboard</a></li> -->
                <li><a href="{{ route('faq') }}"><i class="fa fa-question"></i> FAQ</a></li>
                <li><a href="{{ route('profile', Auth::user()->id) }}"><i class="fa fa-user-circle"></i> Profile</a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Sign Out</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social text-left">
            <a href="https://www.tiktok.com/@kemenkes.bootcamp">
                <img src="{{ asset('dist/img/icon/tik-tok-black.png') }}" width="14"> <small>kemenkesbootcamp</small>
            </a>
            <a href="https://www.instagram.com/kemenkesbootcamp/"><i class="fa fa-instagram"></i> <small>kemenkesbootcamp</small></a>
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('dist/img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <a href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <!-- <li><a href="{{ route('dashboard') }}">Classes</a></li> -->
                            <!-- <li><a href="{{ route('dashboard') }}">Survey Result</a></li> -->
                            <li class="{{ request()->routeIs('jadwal.show') ? 'active' : '' }}">
                                <a href="{{ route('jadwal.show') }}">Schedule</a>
                            </li>
                            <!-- <li class="{{ request()->routeIs('leaderboard') ? 'active' : '' }}">
                                <a href="{{ route('leaderboard') }}">Leaderboard</a>
                            </li> -->
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <nav class="nav-menu">
                        <ul>
                            <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                                <a href="{{ route('profile', Auth::user()->id) }}">Profile</a>
                            </li>
                            <li class="{{ request()->routeIs('logout') ? 'active' : '' }}">
                                <a href="{{ route('logout') }}">Sign Out</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    @if (Session::has('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'error',
            text: '{{ Session::get("failed") }}',
            timer: 2000, // Durasi popup (dalam milidetik)
            showConfirmButton: false // Tombol OK tidak ditampilkan
        });
    </script>
    @endif

    @yield('content')

    <button id="btnToTop" class="btn-to-top btn-lg" title="Home">
        <i class="fa fa-arrow-up"></i>
    </button>

    <audio id="welcomeAudio" loop>
        <source src="{{ asset('dist/music/17aug.mp3') }}">
    </audio>

    <!-- Footer Section Begin -->
    <section class="footer-section" style="margin-top: 26%;">
        <div class="container">
            <div class="copyright-text text-center">
                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | This template is made by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="{{ asset('dist/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('dist/js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.barfiller.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('dist/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dist/js/main.js') }}"></script>

    <script src="{{ asset('dist/js/sweetalert2.all.min.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script> -->
    <script src="{{ asset('dist/js/select2.full.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/0.7.0/chartjs-plugin-datalabels.min.js"></script>

    @yield('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var audio = document.getElementById('welcomeAudio');
            audio.play().catch((error) => {
                console.log('Autoplay diblokir:', error);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.number').on('input', function() {
                // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
                var value = $(this).val().replace(/[^0-9]/g, '');
                // Format dengan menambahkan titik koma setiap tiga digit
                var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '');

                $(this).val(formattedValue);
            });
        });
    </script>

</body>

</html>
