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
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad" style="margin-top: 10%;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="section-title contact-title text-center">
                        <h2>BAGAIMANA SURVEY ANDA TERHADAP PELAYANAN KAMI ?</h2>
                    </div>
                    <div class="section-body">
                        <form action="">
                            @csrf
                            <div class="row mt-5">
                                <div class="col-md-6 col-6">
                                    <div class="survey-option">
                                        <input id="puas" name="result" type="checkbox" class="survey-checkbox" value="puas">
                                        <img src="{{ asset('dist/img/survey/happy.png') }}" class="w-75 face-img mx-4" id="happy-img">
                                        <label for="puas" class="text-center text-white">Puas</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="survey-option">
                                        <input name="result" type="checkbox" class="survey-checkbox" value="tidak puas">
                                        <img src="{{ asset('dist/img/survey/sad.png') }}" class="w-75 face-img mx-4" id="sad-img">
                                        <label for="tidak puas" class="text-center text-white">Tidak Puas</label>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        function confirmSubmit(event) {
            event.preventDefault();

            const form = document.getElementById('form-login');

            var password = $("#password").val();
            var confPass = $("#conf-password").val();
            const inputs = form.querySelectorAll('select[required], input[required], textarea[required]');
            let isFormValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && input.value.trim() === '') {
                    input.style.borderColor = 'red';
                    isFormValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });

            if (isFormValid) {
                Swal.fire({
                    title: "Proses...",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                })

                form.submit();
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
