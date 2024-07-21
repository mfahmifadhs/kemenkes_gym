@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>Konsultasi Kesehatan</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                <div id="alert" class="alert bg-success">
                    <div class="row">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('alert').style.display = 'none';
                    }, 5000);
                </script>
                @endif

                @if ($message = Session::get('failed'))
                <div id="alert" class="alert bg-danger">
                    <div class="row">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('alert').style.display = 'none';
                    }, 5000);
                </script>
                @endif

                <div class="section-body mb-5">
                    <div class="schedule p-3 border-main">
                        <form id="form" action="{{ route('konsul.store') }}" method="GET">
                            @csrf
                            <input type="hidden" name="member_id" value="{{ Auth::user()->member_id }}">
                            <input type="hidden" name="dokter_id" value="{{ $dokter->id_dokter }}">
                            <div class="row text-white mb-2">
                                <div class="col-md-3">
                                    <img src="{{ asset('dist/img/'. $dokter->foto_dokter) }}" alt="">
                                </div>
                                <div class="col-md-9 mt-2">
                                    <h5 class="font-weight-bold">{{ $dokter->nama_dokter }}</h5>
                                    <h5 class="text-secondary font-weight-bold mb-3">{{ $dokter->spesialisasi }}</h5>

                                    <small class="text-white">{{ $dokter->profil_dokter }}</small> <br>
                                    @if (Auth::user()->konsul->where('status', 'false')->count() == 0)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small>
                                                <label class="mt-4"><b>Tahapan: </b></label> <br>
                                                1. Tes Vo2Max SIPGAR <br>
                                                2. Tes Fitness <br>
                                                3. Konsultasi
                                            </small>
                                        </div>

                                        <div class="col-md-8">
                                            <small>
                                                <label class="mt-4"><b>Lokasi & Jam Praktek: </b></label> <br>
                                                <i class="fa fa-calendar"></i> Setiap Hari Jumat <br>
                                                <i class="fa fa-clock-o"></i> 07.00 WIB s/d 09.00 WIB <br>
                                                <i class="fa fa-map-pin"></i> Ruang Dokter, Kemenkes Bootcamp & Fitness Center <br>
                                            </small>
                                        </div>
                                        <div class="col-md-12">
                                            <small>
                                                <label class="mt-4"><b>Syarat & Ketentuan: </b></label> <br>
                                                1. Merupakan Pegawai Kantor Pusat / UPT Kemenkes (menunjukan identitas pegawai). <br>
                                                2. Melakukan tes sesuai tahapan, sebelum melakukan konsultasi. <br>
                                                3. Membuat jadwal tes dengan <i>coach</i>. <br>
                                                4. Jika setelah <i>booking</i> dilakukan pembatalan, maka antrian dimulai dari awal. <br>
                                                5. Kuota konsultasi hanya <b>4 pasien / hari</b>. <br>
                                                6. Jadwal konsultasi akan diberikan oleh <i>coach</i>, setelah melakukan semua tes.
                                            </small>
                                        </div>
                                    </div>

                                    <button type="submit" onclick="confirmSubmit(event)" class="btn btn-primary btn-block">Konsul</button>
                                    @elseif (!$userKonsul->first()->konsultasi)
                                    <a href="{{ route('konsul.cancel') }}" onclick="confirmCancel(event)" class="btn btn-danger btn-sm mt-2 btn-block">
                                        Batalkan
                                    </a>
                                    @elseif ($userKonsul->first()->konsultasi)
                                    <a href="{{ route('konsul.reset') }}" onclick="confirmReset(event)" class="btn btn-primary btn-sm mt-2 btn-block">
                                        Konsultasi Kembali
                                    </a>
                                    <a href="{{ route('konsul.download', $userKonsul->first()->id_konsultasi) }}" onclick="confirmDownload(event)" class="btn btn-primary bg-danger btn-sm mt-2 btn-block">
                                        Download Hasil Konsultasi
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            @if ($userKonsul->where('status', 'false')->count() != 0)
                            <div class="col-md-3">
                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl {{ $userKonsul->where('test_sipgar', 1)->first() ? 'badge-success' : 'badge-danger' }}"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Tes Vo2Max SIPGAR</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl {{ $userKonsul->where('test_fitness', 1)->first() ? 'badge-success' : 'badge-danger' }}"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Tes Fitness</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl {{ $userKonsul->where('konsultasi', 1)->first() ? 'badge-success' : 'badge-danger' }}"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Konsul Dokter</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($userKonsul->where('test_sipgar', 0)->first() || $userKonsul->where('test_fitness', 0)->first())
                            <div class="col-md-9 col-12 mt-5">
                                <div class="vertical-line"></div>
                                <h4 class="text-white ml-4 text-uppercase">Mohon untuk melakukan Tes Vo2Max SIPGAR & Tes Fitness</h4>
                                <h6 class="text-secondary ml-4">untuk melakukan tes silahkan hubungi Coach untuk mengatur jadwal.</h6>

                                <div class="input-group ml-4">
                                    <a href="https://api.whatsapp.com/send?phone=+{{ $phoneSalsa }}&text={{ $msg }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fa fa-male"></i> Hubungi Coach Wiyata
                                    </a>
                                    <a href="https://api.whatsapp.com/send?phone=+{{ $phoneWiyata }}&text={{ $msg }}" target="_blank" class="btn btn-primary btn-sm ml-2">
                                        <i class="fa fa-female"></i> Hubungi Coach Salsa
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if ($userKonsul->first()?->tanggal_konsul && $userKonsul->first()->status == 'false')
                            <div class="col-md-9 col-12 mt-5">
                                <div class="vertical-line"></div>
                                <label class="text-success text-sm ml-4 font-weight-bold">Berikut jadwal konsultasi anda:</label> <br>
                                <label class="text-white ml-4">
                                    <span><i class="fa fa-calendar"></i> {{ Carbon\Carbon::parse($userKonsul->first()->tanggal_konsul)->isoFormat('DD MMMM Y') }}</span>
                                </label> <br>

                                <label class="text-white ml-4">
                                    <span><i class="fa fa-clock-o"></i>
                                        @if ($userKonsul->first()->waktu_konsul == 1) 07.00 WIB s/d 07.30 WIB @endif
                                        @if ($userKonsul->first()->waktu_konsul == 2) 07.30 WIB s/d 08.00 WIB @endif
                                        @if ($userKonsul->first()->waktu_konsul == 3) 08.00 WIB s/d 08.30 WIB @endif
                                        @if ($userKonsul->first()->waktu_konsul == 4) 08.30 WIB s/d 09.00 WIB @endif
                                    </span>
                                </label> <br>

                                <label class="text-white ml-4">
                                    <span><i class="fa fa-map-pin"></i> Ruang Dokter, Kemenkes Bootcamp & Fitness Center</span>
                                </label> <br>

                                @if ($userKonsul->first()->konsultasi == 1)
                                <label class="text-white ml-4 mt-4">
                                    <span><i class="fa fa-pencil"></i> Catatan Dokter: </span>
                                    <p class="text-white">{{ $userKonsul->first()->catatan_pasien }}</p>
                                </label>
                                @endif
                            </div>
                            @endif
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
            title: 'Konsultasi ?',
            text: 'Untuk konsultasi dengan dokter, diperlukan beberapa tes terlebih dahulu',
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

    function confirmReset(event) {
        event.preventDefault();

        const url = event.currentTarget.href;

        Swal.fire({
            title: 'Konsultasi',
            text: 'Konsultasi kembali',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function confirmCancel(event) {
        event.preventDefault();

        const url = event.currentTarget.href;

        Swal.fire({
            title: 'Batalkan',
            text: 'Batalkan Konsultasi, Antrian akan dibatalkan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function confirmDownload(event) {
        event.preventDefault();

        const url = event.currentTarget.href;

        Swal.fire({
            title: "Loading...",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Create a temporary link to handle the download
        const link = document.createElement('a');
        link.href = url;
        link.style.display = 'none';
        document.body.appendChild(link);

        link.click();

        // Clean up
        document.body.removeChild(link);

        // Function to check download status
        const checkDownloadStatus = async () => {
            try {
                const response = await fetch(url);
                if (response.ok) {
                    // Download completed
                    Swal.close();
                    Swal.fire({
                        title: "File sudah diunduh",
                        text: "Klik OK untuk menyegarkan halaman.",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    // Handle errors if needed
                    console.error('Download error:', response.statusText);
                }
            } catch (error) {
                console.error('Download error:', error);
            }
        };

        // Start checking download status
        checkDownloadStatus();
    }
</script>


@endsection
@endsection
