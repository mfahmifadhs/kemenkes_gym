@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad h-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto mt-5 text-center">
                <div class="section-title contact-title text-center">
                    <h2><u>PEMINJAMAN LOKER</u></h2>
                </div>
            </div>
            @if ($status == 'false')
            <div class="col-lg-6 mx-auto ">
                <div class="leave-comment">
                    @if ($message = Session::get('success'))
                    HALO
                    @endif
                    <label class="text-white h4 mb-0">ID MEMBER</label><br>
                    <small class="text-white mt-0">Please scan ID Member here.</small>
                    <input type="text" name="member_id" class="form-control bg-white number" id="member_id" placeholder="Member ID" min="0" maxlength="19">
                </div>
            </div>
            @endif

            @if ($status == 'true')
            <div class="col-lg-8">
                <div class="leave-comment">
                    <label class="text-white h4 mb-0">ID MEMBER</label><br>
                    <small class="text-white mt-0">Please scan ID Member here.</small>
                    <input type="text" name="member_id" class="form-control bg-white number" id="member_id" placeholder="Member ID" min="0" maxlength="19">
                </div>
            </div>
            <div class="col-lg-4 border-main p-2 mt-3">
                <center>
                    <h3 class="text-main">Nomor Loker</h3>
                    <input type="text" class="bottom-border-input number" placeholder="Enter a number">
                </center>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Contact Section End -->

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
                url: '/loker/false/' + member_id,
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
                            timer: 1000,
                            showConfirmButton: false
                        }).then((result) => {
                            // location.reload();
                            window.location.href = '/loker/true/' + member_id;
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
                            // location.reload();
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
                            // location.reload();
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
                            // location.reload();
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
                        // location.reload();
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
            url: "",
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
                            <td class="text-center">${item.jadwal ? item.jadwal.kelas.nama_kelas : 'EXERCISE'}</td>
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
