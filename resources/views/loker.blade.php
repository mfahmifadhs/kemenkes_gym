@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mx-auto mt-5 text-center">
                <div class="section-title contact-title text-center">
                    <h2><u>PEMINJAMAN LOKER</u></h2>
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
                <a href="{{ route('loker') }}" class="btn btn-main btn-sm text-white bg-main mb-3">
                    <i class="fa fa-arrow-circle-o-left"></i> Kembali
                </a>
                <div class="border-main p-2 text-center">
                    <h3 class="text-main">Nomor Loker</h3>
                    <input type="number" class="bottom-border-input number" id="no_loker" style="-webkit-appearance: none;"><br>
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
                <div class="border-main p-2 mt-3 text-white">
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
                        <div class="col-md-8 col-8">: 21 Januari 2024</div>
                        <div class="col-md-4 col-4">Waktu Pinjam</div>
                        <div class="col-md-8 col-8">: 10.50 WIB</div>
                    </div>
                </div>

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
    document.addEventListener('DOMContentLoaded', function() {
        var memberInput = document.getElementById('member_id');
        memberInput.focus();
    });
    document.addEventListener('DOMContentLoaded', function() {
        var noLoker = document.getElementById('no_loker');
        noLoker.focus();

        if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
            noLoker.click();
        }
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
