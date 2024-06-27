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
    <link rel="stylesheet" href="{{ asset('dist/css/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/select2.css') }}">
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
        <!-- <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div> -->
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="/">Home</a></li>
                            @if (!request()->is('registration') && !request()->is('login') && !request()->is('activation') && !request()->is('mail/reset/password') && !request()->is('Attendance'))
                <li><a href="#class">Classes</a></li>
                <li><a href="#schedule">Schedule</a></li>
                <li><a href="#survey">Survey Result</a></li>
                <li><a href="#gallery">Gallery</a></li>
                @endif
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('daftar') }}">Register</a></li>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="/">
                            <img src="{{ asset('dist/img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <nav class="nav-menu">
                        <ul>
                            <li><a href="/">Home</a></li>
                            @if (!request()->is('registration') && !request()->is('login') && !request()->is('activation') && !request()->is('mail/reset/password') && !request()->is('Attendance'))
                            <li><a href="#class">Classes</a></li>
                            <li><a href="#schedule">Schedule</a></li>
                            <li><a href="#survey">Survey Result</a></li>
                            <li><a href="#gallery">Gallery</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="nav-menu">
                        <ul>
                            <li class="{{ request()->routeIs('daftar') ? 'active' : '' }}">
                                <a href="{{ route('daftar') }}">Register</a>
                            </li>
                            <li class="{{ request()->routeIs('login') ? 'active' : '' }}">
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                    <div class="top-option">
                        <div class="to-social">
                            <a href="https://www.tiktok.com/@kemenkes.bootcamp"><img src="{{ asset('dist/img/icon/tik-tok.png') }}" width="15"></a>
                            <a href="https://www.instagram.com/kemenkesbootcamp/"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    @yield('content')

    <button id="btnToTop" class="btn-to-top btn-lg" title="Home">
        <i class="fa fa-arrow-up"></i>
    </button>

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fs-about">
                        <div class="fa-logo">
                            <a href="#"><img src="{{ asset('dist/img/logo.png') }}" alt=""></a>
                        </div>
                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore dolore magna aliqua endisse ultrices gravida lorem.</p>
                        <div class="fa-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa  fa-envelope-o"></i></a>
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Useful links</h4>
                        <ul>
                            <li><a href="/">Home</a></li>
                            @if (!request()->is('registration') && !request()->is('login'))
                            <li><a href="#class">Classes</a></li>
                            <li><a href="#choices">Classes Choices</a></li>
                            <li><a href="#gallery">Gallery</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('daftar') }}">Registration</a></li>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Tips & Guides</h4>
                        <div class="fw-recent">
                            <h6><a href="#">Don't stay up late and drink lots of water</a></h6>
                        </div>
                        <div class="fw-recent">
                            <h6><a href="#">Spend 30 minutes every day for exercise</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
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
    <script src="{{ asset('dist/js/select2.full.js') }}"></script>
    <script src="{{ asset('dist/js/sweetalert2.all.min.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/0.7.0/chartjs-plugin-datalabels.min.js"></script>

    @yield('js')

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
        // Password
        $(document).ready(function() {
            $("#eye-icon-pass").click(function() {
                var password = $("#password");
                var icon = $("#eye-icon-pass");
                if (password.attr("type") == "password") {
                    password.attr("type", "text");
                    icon.removeClass("fa fa-eye").addClass("fa fa-eye-slash");
                } else {
                    password.attr("type", "password");
                    icon.removeClass("fa fa-eye-slash").addClass("fa fa-eye");
                }
            });

            $("#eye-conf-pass").click(function() {
                var password = $("#conf-password");
                var icon = $("#eye-conf-pass");
                if (password.attr("type") == "password") {
                    password.attr("type", "text");
                    icon.removeClass("fa fa-eye").addClass("fa fa-eye-slash");
                } else {
                    password.attr("type", "password");
                    icon.removeClass("fa fa-eye-slash").addClass("fa fa-eye");
                }
            });

            $("#form-daftar").submit(function() {
                var password = $("#password").val();
                var conf_password = $("#conf-password").val();
                if (password != conf_password) {
                    alert("Konfirmasi password tidak sama!");
                    return false;
                }
                return true;
            });
        });
    </script>

</body>

</html>
