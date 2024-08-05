@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row mb-2 mt-5">
                    <div class="col-7 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>{{ $judul }}</u></h4>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="schedule p-3 border-main">
                        <div class="row text-white mb-2">
                            <div class="col-md-3 text-center mt-5">
                                @if ($id == 'fatloss')
                                <img src="{{ asset('dist/img/challenge/fatloss.png') }}" alt="">
                                @else
                                <img src="{{ asset('dist/img/challenge/musclegain.png') }}" alt="">
                                @endif
                            </div>
                            <div class="col-md-9 col-12">
                                <h6 class="font-weight-bold mt-2 text-secondary">Challenge</h6>
                                <h5 class="text-secondary font-weight-bold mb-3 text-warning">{{ $judul }}</h5>

                                <div class="row">
                                    <div class="col-md-8">
                                        <small>
                                            <label class="mt-4"><b>Lokasi: </b></label> <br>
                                            <i class="fa fa-map-pin"></i> Kemenkes Bootcamp & Fitness Center <br>
                                        </small>
                                    </div>

                                    <div class="col-md-12">
                                        <small>
                                            <label class="mt-4"><b>Kategori: </b></label> <br>
                                            <div class="input-group">
                                                <span style="width: 50%;"><i class="fa fa-dot-circle-o text-danger"></i> Male Fat Loss Challenge</span>
                                                <span style="width: 50%;"><i class="fa fa-dot-circle-o text-danger"></i> Female Fat Loss Challenge</span>
                                            </div>
                                            <div class="input-group">
                                                <span style="width: 50%;"><i class="fa fa-dot-circle-o text-danger"></i> Male Muscle Gain Challenge</span>
                                                <span style="width: 50%;"><i class="fa fa-dot-circle-o text-danger"></i> Female Muscle Gain Challenge</span>
                                            </div>
                                        </small>
                                    </div>

                                    <div class="col-md-12">
                                        <small>
                                            <label class="mt-4"><b>Tahapan Penimbangan: </b></label> <br>
                                            1. Tahap 1 : 5 Agustus 2024 - 9 Agustus 2024 <br>
                                            2. Tahap 2 : 2 September 2024 - 6 September 2024 <br>
                                            3. Tahap 3 : 1 Oktober 2024 - 4 Oktober 2024 <br>
                                            4. Tahap 4 : 28 Oktober 2024 - 31 Oktober 2024 <br>
                                        </small>
                                    </div>

                                    <div class="col-md-12">
                                        <small>
                                            <label class="mt-4"><b>Syarat & Ketentuan: </b></label> <br>
                                            1. Peserta merupakan pegawai Kantor Pusat/ UPK / Mitra Kementerian Kesehatan RI. <br>
                                            2. Bersedia untuk melakukan foto saat pendaftaran dan pengukuran di akhir <i>challenge</i>. <br>
                                            3. Menyetujui dan memberi izin dalam penggunaan foto diri untuk kepentingan publikasi kepada panitia penyelenggara. <br>
                                            4. Melakukan penimbangan sesuai tahapan penimbangan. <br>
                                            5. Jika tidak melakukan penimbangan sesuai tahapan, maka akan dinyatakan gugur. <br>
                                            6. Pemenang pada challenge adalah 3 (tiga) orang dengan progres terbaik pada setiap kategori. <br>
                                            7. Tantangan dilakukan secara aman dan nyaman. <br>
                                            8. Keputusan tim pengelola Kemenkes Bootcamp & Fitness Center terhadap hasil dari challenge ini tidak dapat diganggu gugat. <br>

                                            <br>
                                            <b>Untuk syarat & ketentuan lainnya, silahkan cek link berikut:
                                                <a href="https://link.kemkes.go.id/FLnMGChallenges"><u>Ketentuan</u></a>
                                            </b>
                                        </small>
                                    </div>

                                    <div class="col-md-12">
                                        <small>
                                            <label class="mt-4"><b>Hadiah: </b></label> <br>
                                            1. Mendapatkan loker khusus selama 3 bulan. <br>
                                            2. Plakat pemenang <i>challenge</i>. <br>
                                            3. <i>Free whey protein</i> dan <i>fitness supplement</i>. <br>
                                            4. Bebas mengikuti kelas selama 3 bulan (tanpa join kelas). <br>
                                            5. Pemenang challenge akan diumumkan di hari kesehatan Nasional.
                                        </small>
                                    </div>
                                </div>
                                <form id="form" action="{{ route('challenge.join', Auth::user()->id) }}">
                                    <input type="hidden" name="challenge_id" value="{{ $kode }}">
                                    <button type="submit" onclick="confirmSubmit(event)" class="btn btn-primary btn-block">Daftar Challenge</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@section('js')
<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: 'Daftar Challenge',
            text: 'Apakah kamu menyetujui seluruh syarat & ketentuan challenge ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Loading...",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                })

                form.submit();
            }
        });

    }
</script>
@endsection

@endsection
