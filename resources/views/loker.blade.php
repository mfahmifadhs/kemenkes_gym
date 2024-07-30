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
    <header class="header-section" style="margin-top: 4%;">
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
    <section class="contact-section spad mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mx-auto mt-4 text-center">
                    <div class="section-title contact-title text-center">
                        <h2 class="text-pink">PEMINJAMAN LOKER</h2>
                    </div>
                </div>
                @if ($status == 'false')
                <div class="col-md-6 mx-auto">
                    <div class="leave-comment">
                        <label class="text-white h4 mb-0">ID MEMBER</label><br>
                        <small class="text-white mt-0">Scan QR Code disini / masukkan 4 digit terakhir nomor member.</small>
                        <input type="number" name="member_id" class="form-control bg-white" id="member_id" placeholder="Member ID" min="0" maxlength="19">
                    </div>
                </div>
                @endif

                @if ($status == 'true')
                <div class="col-md-6">
                    <a href="{{ route('loker') }}" class="btn btn-main btn-sm text-white {{ $member->jenis_kelamin == 'male' ? 'bg-main' : 'bg-pink' }} mb-3">
                        <i class="fa fa-arrow-circle-o-left"></i> Kembali
                    </a>
                    <div class="{{ $member->jenis_kelamin == 'male' ? 'border-main' : 'border-pink' }} p-2 text-center">
                        <h3 class="{{ $member->jenis_kelamin == 'male' ? 'text-main' : 'text-pink' }}">Nomor Loker</h3>
                        <input id="no_loker" type="number" name="no_loker" class="bottom-border-input number"><br>
                        <!-- <label class="text-white">Pilih Jaminan Identitas :</label>
                    <div class="input-group small ml-5">
                        <label for="ktp" class="bg-main p-2 rounded">
                            <input id="kp" type="radio" name="jaminan" value="ktp">
                            <b>Kartu Pegawai</b>
                        </label>
                        <label for="ktp" class="bg-main p-2 rounded ml-2">
                            <input id="ktp" type="radio" name="jaminan" value="ktp">
                            <b>KTP</b>
                        </label>
                        <label for="ktp" class="bg-main p-2 rounded mx-2">
                            <input id="sim" type="radio" name="jaminan" value="sim">
                            <b>SIM</b>
                        </label>
                        <label for="ktp" class="bg-main p-2 rounded">
                            <input id="ktp" type="radio" name="jaminan" value="lainnya">
                            <b>Lainnya</b>
                        </label>
                    </div> -->
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="{{ $member->jenis_kelamin == 'male' ? 'border-main' : 'border-pink' }} p-2 mt-5 text-white">
                        <div class="row p-2">
                            <div class="col-md-12 mb-2">Profil Member</div>
                            <div class="col-md-4 col-4">Member ID</div>
                            <div class="col-md-8 col-8">: {{ $member->member_id }}</div>
                            <div class="col-md-4 col-4">Nama</div>
                            <div class="col-md-8 col-8">: {{ $member->nama }}</div>
                            <div class="col-md-4 col-4">NIP/NIK</div>
                            <div class="col-md-8 col-8">: {{ $member->nip_nik }}</div>
                            <div class="col-md-4 col-4">Jenis Kelamin</div>
                            <div class="col-md-8 col-8">: {{ $member->jenis_kelamin == 'male' ? 'Laki-laki' : 'Perempuan' }}</div>
                            <div class="col-md-4 col-4">Asal</div>
                            <div class="col-md-8 col-8">: {{ $member->instansi == 'pusat' ? $member->uker->nama_unit_kerja : $member->nama_instansi }}</div>
                            <div class="col-md-4 col-4">Tanggal Pinjam</div>
                            <div class="col-md-8 col-8">: {{ Carbon\Carbon::now()->isoFormat('dddd, DD MMMM Y') }}/div>
                            <div class="col-md-4 col-4">Waktu Pinjam</div>
                            <div class="col-md-8 col-8">: {{ Carbon\Carbon::now()->format('H:i:s') }} WIB</div>
                        </div>
                    </div>

                </div>
                @endif
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
        document.addEventListener('DOMContentLoaded', function() {
            var memberInput = document.getElementById('member_id');
            memberInput.focus();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var noLoker = document.getElementById('no_loker');
            noLoker.focus();
        });
    </script>

    <!-- Cek Member -->
    <script>
        $(document).ready(function() {
            $('#member_id').on('change', function() {
                var member_id = $(this).val();

                $.ajax({
                    url: '/loker/false/' + member_id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        console.log('halo' + response)
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Halo',
                                text: 'Selamat Datang',
                                timer: 1000,
                                showConfirmButton: false
                            }).then((result) => {
                                // location.reload();
                                window.location.href = '/loker/true/' + member_id;
                            });
                        } else if (response.ongoing) {
                            Swal.fire({
                                icon: 'failed',
                                title: 'Sedang Meminjam',
                                text: '',
                                timer: 1000,
                                showConfirmButton: false
                            }).then((result) => {
                                window.location.href = '/loker';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Data Tidak Ditemukan',
                                timer: 1000, // Durasi popup (dalam milidetik)
                                showConfirmButton: false // Tombol OK tidak ditampilkan
                            }).then((result) => {
                                // Callback ini akan dipanggil setelah popup Swal ditutup
                                // Memuat ulang halaman
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data Tidak Ditemukan',
                            timer: 1000, // Durasi popup (dalam milidetik)
                            showConfirmButton: false // Tombol OK tidak ditampilkan
                        }).then((result) => {
                            // Callback ini akan dipanggil setelah popup Swal ditutup
                            // Memuat ulang halaman
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>

    <!-- Input loker -->
    <script>
        $(document).ready(function() {
            $('#no_loker').on('change', function() {
                var member_id = <?php echo $status == 'false' ? 0 : $member->id; ?>;
                var no_loker  = $(this).val();

                console.log('halo', member_id)
                $.ajax({
                    url: '/loker/post/'+ member_id +'/'+ no_loker,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Berhasil menyimpan peminjaman loker',
                                timer: 1000,
                                showConfirmButton: false
                            }).then((result) => {
                                // location.reload();
                                window.location.href = '/loker';
                            });
                        } else if (response.pengembalian) {
                            Swal.fire({
                                icon: 'success',
                                title: 'PENGEMBALIAN BERHASIL',
                                text: 'Terima kasih, sampai jumpa kembali',
                                timer: 1000,
                                showConfirmButton: false
                            }).then((result) => {
                                window.location.href = '/loker';
                            });
                        } else if (response.ongoing) {
                            Swal.fire({
                                icon: 'error',
                                title: 'SEDANG MEMINJAM',
                                text: '',
                                timer: 1000,
                                showConfirmButton: false
                            }).then((result) => {
                                window.location.href = '/loker';
                            });
                        } else if (response.full) {
                            Swal.fire({
                                icon: 'error',
                                title: 'LOKER TIDAK TERSEDIA',
                                text: '',
                                timer: 1000,
                                showConfirmButton: false
                            }).then((result) => {
                                window.location.href = '/loker/true/' + member_id;
                            });
                        } else {
                            document.getElementById('sound-gagal').play();
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Data Tidak Ditemukan',
                                timer: 1000, // Durasi popup (dalam milidetik)
                                showConfirmButton: false // Tombol OK tidak ditampilkan
                            }).then((result) => {
                                // Callback ini akan dipanggil setelah popup Swal ditutup
                                // Memuat ulang halaman
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        document.getElementById('sound-gagal').play();
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data Tidak Ditemukan',
                            timer: 1000, // Durasi popup (dalam milidetik)
                            showConfirmButton: false // Tombol OK tidak ditampilkan
                        }).then((result) => {
                            // Callback ini akan dipanggil setelah popup Swal ditutup
                            // Memuat ulang halaman
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
