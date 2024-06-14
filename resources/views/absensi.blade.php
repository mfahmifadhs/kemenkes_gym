@extends('app')
@section('content')

<!-- Hero Section Begin -->
<!-- <section class="hero-section">
    <div class="hs-slider owl-carousel">
        @for($i = 3; $i >= 1; $i--)
        <div class="hs-item set-bg" data-setbg="{{ asset('dist/img/hero-'.$i.'.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-6">
                        <div class="hi-text">
                            <h1>You're <strong>stronger</strong> than you think</h1>
                            <a href="{{ route('daftar') }}" class="primary-btn btn-normal">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</section> -->
<!-- Hero Section End -->

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto mt-5 text-center">

                <div class="section-title contact-title text-center">
                    <h2><u>KEHADIRAN</u></h2>
                </div>
            </div>
            <div class="col-lg-12 mx-auto mt-0 mb-4 text-center">
                <img src="{{ asset('dist/img/kehadiran.png') }}" class="img-fluid w-100" alt="">
            </div>
            <div class="col-lg-6 mx-auto ">
                <div class="leave-comment">
                    @if ($message = Session::get('success'))
                    <div id="alert" class="alert bg-success">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('alert').style.display = 'none';
                        }, 10000);
                    </script>
                    @endif
                    @if ($message = Session::get('failed'))
                    <div id="alert" class="alert bg-danger">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('alert').style.display = 'none';
                        }, 5000);
                    </script>
                    @endif
                    <label class="text-white h4 mb-0">ID MEMBER</label><br>
                    <small class="text-white mt-0">Please scan ID Member here.</small>
                    <input type="text" name="member_id" class="form-control bg-white number" id="member_id" placeholder="Member ID" min="0" maxlength="19">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<!-- Schedule Section Begin -->
<section class="choseus-section spad h-100 my-auto">
    <div id="schedule" class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>DAFTAR HADIR</h2>
                </div>
            </div>

            <div class="col-lg-12 mb-5">
                <h1 class="text-white text-center">
                    <span id="total"></span>
                </h1>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive" style="max-height: 300px;overflow-y: auto;">
                    <table class="table table-striped text-white small">
                        <thead>
                            <tr>
                                <th colspan="4">
                                    {{ \Carbon\Carbon::yesterday()->isoFormat('DD MMMM Y') }}
                                </th>
                            </tr>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Asal</th>
                                <th>Waktu Datang</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Schedule Section End -->

<!-- Schedule Section Begin -->
<section class="choseus-section spad h-100 my-auto">
    <div id="schedule" class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>SCHEDULE (COMING SOON) !</h2>
                </div>
            </div>

            <div class="col-lg-12">
                <img src="{{ asset('dist/img/schedule.png') }}" class="img-fluid w-100" alt="">
            </div>
        </div>
    </div>
</section>
<!-- Schedule Section End -->

<audio id="sound-datang" src="{{ asset('dist/sound/sound-datang.mp3') }}" preload="auto"></audio>
<audio id="sound-gagal" src="{{ asset('dist/sound/sound-gagal.mp3') }}" preload="auto"></audio>
<audio id="sound-thanks" src="{{ asset('dist/sound/sound-thanks.mp3') }}" preload="auto"></audio>
<audio id="sound-hadir" src="{{ asset('dist/sound/sound-hadir.mp3') }}" preload="auto"></audio>

@section('js')
<script>
    $(document).ready(function() {
        $('#member_id').on('change', function() {
            var member_id = $(this).val();

            $.ajax({
                url: '/absensi/post/' + member_id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        document.getElementById('sound-datang').play();
                        Swal.fire({
                            icon: 'success',
                            title: 'Halo',
                            text: 'Selamat Datang',
                            timer: 1000, // Durasi popup (dalam milidetik)
                            showConfirmButton: false // Tombol OK tidak ditampilkan
                        }).then((result) => {
                            // Callback ini akan dipanggil setelah popup Swal ditutup
                            // Memuat ulang halaman
                            location.reload();
                        });
                    } else if (response.thanks) {
                        document.getElementById('sound-thanks').play();
                        Swal.fire({
                            icon: 'success',
                            title: 'Terima Kasih',
                            text: 'Sampai Jumpa',
                            timer: 1000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    } else if (response.hadir) {
                        document.getElementById('sound-hadir').play();
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Sudah melakukan rekam kehadiran',
                            timer: 1000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
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

<script>
    // Menggunakan event DOMContentLoaded untuk memastikan semua elemen telah dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Dapatkan elemen input
        var memberInput = document.getElementById('member_id');

        // Fokuskan pada elemen input
        memberInput.focus();
    });
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('absen.list') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" // Sertakan token CSRF
            },
            success: function(data) {
                let total = data.length;
                let tbody = $('table tbody');
                let totalSpan = $('#total');

                totalSpan.text(total);

                data.forEach((item, index) => {
                    let row = `<tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${item.member.nama}</td>
                            <td class="text-center">${item.member.uker.nama_unit_kerja}</td>
                            <td class="text-center">${item.waktu_masuk}</td>
                        </tr>`;
                    tbody.append(row);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
            }
        });
    });
</script>

@endsection
@endsection
