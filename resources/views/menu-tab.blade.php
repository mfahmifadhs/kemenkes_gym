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

<body style="background-color: #151515;">
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header-section" style="margin-top: 5%;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 mx-auto text-center">
                    <div class="logo">
                        <a href="/">
                            <img src="{{ asset('dist/img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    @if ($message = Session::get('success'))
                    <div id="alert" class="alert bg-success">
                        <div class="row">
                            <p style="color:white;margin: auto;">{{ $message }}</p>
                        </div>
                    </div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('alert').style.display = 'none';
                        }, 3000);
                    </script>
                    @endif
                    <div class="section-body" style="margin-top: 10%;">
                        <div class="row mt-5">
                            <div class="col-md-6 col-6">
                                <a href="" onclick="confirmSubmit(event, `{{ route('survey-kepuasan.store', 'puas') }}`)" class="btn btn-default">
                                    <div class="survey-option border-main">
                                        <input id="puas" name="result" type="checkbox" class="survey-checkbox" value="puas">
                                        <img src="{{ asset('dist/img/menu-tab/loker.png') }}" class="w-75 face-img mx-4 p-2">
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-6">
                                <a href="" onclick="confirmSubmit(event, `{{ route('survey-kepuasan.store', 'tidakpuas') }}`)" class="btn btn-default">
                                    <div class="survey-option border-main">
                                        <input name="result" type="checkbox" class="survey-checkbox" value="tidak puas">
                                        <img src="{{ asset('dist/img/menu-tab/survey.png') }}" class="w-75 face-img mx-4 p-2">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->


    <button id="btnToTop" class="btn-to-top btn-lg" title="Home">
        <i class="fa fa-arrow-up"></i>
    </button>

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


    <script>
        function confirmSubmit(event, url) {
            event.preventDefault();

            // Check if form is valid (you need to define your own validation logic)
            const isFormValid = true; // Replace with your form validation logic

            if (isFormValid) {
                Swal.fire({
                    title: "Loading...",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Redirect to the URL after a short delay to allow Swal to show loading
                setTimeout(() => {
                    window.location.href = url;
                }, 500); // You can adjust the delay as needed
            } else {
                Swal.fire({
                    title: 'Gagal',
                    text: 'Seluruh Kolom Harus Diisi',
                    icon: 'error',
                });
            }
        }
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dapatkan semua elemen gambar dengan kelas face-img
            var faceImages = document.querySelectorAll('.face-img');

            // Fungsi untuk mengubah warna gambar
            function toggleFaces(clickedImg) {
                faceImages.forEach(function(img) {
                    if (img === clickedImg) {
                        // Gambar yang diklik menjadi merah
                        img.classList.add('red-face');
                    } else {
                        // Gambar lainnya menjadi kuning
                        img.classList.remove('red-face');
                    }
                });
            }

            // Tambahkan event listener untuk setiap gambar
            faceImages.forEach(function(img) {
                img.addEventListener('click', function() {
                    toggleFaces(img);
                });
            });
        });
    </script>

</body>

</html>
