@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5">
                <div class="section-title contact-title text-center">
                    <h2><u>Attendance</u></h2>
                </div>
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
                    <input type="number" name="member_id" class="form-control bg-white" id="member_id" placeholder="Member ID" min="0">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<audio id="sound-datang" src="{{ asset('dist/sound/sound-datang.mp3') }}" preload="auto"></audio>
<audio id="sound-gagal" src="{{ asset('dist/sound/sound-gagal.mp3') }}" preload="auto"></audio>
<audio id="sound-thanks" src="{{ asset('dist/sound/sound-thanks.mp3') }}" preload="auto"></audio>

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
                            timer: 3500, // Durasi popup (dalam milidetik)
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
                            timer: 3500,
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
                            timer: 3700, // Durasi popup (dalam milidetik)
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
                        timer: 3500, // Durasi popup (dalam milidetik)
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

@endsection
@endsection