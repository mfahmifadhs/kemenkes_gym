@extends('dashboard.layout.app')
@section('content')

@if (Session::has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ Session::get("success") }}',
    });
</script>
@endif

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
                        <a href="{{ route('konsul') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="section-body mb-5">
                    <div class="schedule p-3 border-main">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Tes Vo2Max SIPGAR</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Tes Fitness</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Konsul Dokter</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-12 mt-3">
                                <div class="vertical-line"></div>
                                <label class="text-main text-sm ml-4 font-weight-bold">Jadwal konsultasi :</label> <br>
                                <label class="text-white ml-4">
                                    <span><i class="fa fa-calendar"></i> {{ Carbon\Carbon::parse($konsul->tanggal_konsul)->isoFormat('DD MMMM Y') }}</span>
                                </label> <br>

                                <label class="text-white ml-4">
                                    <span><i class="fa fa-clock-o"></i>
                                        @if ($konsul->waktu_konsul == 1) 07.00 WIB s/d 07.20 WIB @endif
                                        @if ($konsul->waktu_konsul == 2) 07.20 WIB s/d 08.40 WIB @endif
                                        @if ($konsul->waktu_konsul == 3) 07.40 WIB s/d 08.00 WIB @endif
                                        @if ($konsul->waktu_konsul == 4) 08.00 WIB s/d 08.20 WIB @endif
                                        @if ($konsul->waktu_konsul == 5) 08.20 WIB s/d 08.40 WIB @endif
                                        @if ($konsul->waktu_konsul == 6) 08.40 WIB s/d 09.00 WIB @endif
                                    </span>
                                </label> <br>

                                <label class="text-white ml-4">
                                    <span><i class="fa fa-map-pin"></i> Ruang Dokter, Kemenkes Bootcamp & Fitness Center</span>
                                </label> <br>

                                @if ($konsul->konsultasi == 1)
                                <label class="text-white ml-4 mt-4">
                                    <span><i class="fa fa-pencil"></i> Catatan Dokter: </span>
                                    <p class="text-white">{!! nl2br($konsul->catatan_pasien) !!}</p>
                                </label>
                                @endif
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
