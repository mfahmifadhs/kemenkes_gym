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
                            <h4 class="text-main"><u>{{ $data->challenge->nama_challenge }}</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('challenge') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="section-body mb-5">
                    <div class="schedule p-3 border-main">
                        <div class="text-center">
                            <i class="fa fa-check-circle fa-5x text-success"></i>
                            <h4 class="text-success text-uppercase">
                                <b>Anda terdaftar pada {{ $data->challenge->nama_challenge }}</b>
                            </h4>
                            <h6 class="text-white text-xs">
                                <b>Silahkan download form dibawah ini dan dibawa pada saat penimbangan Tahap 1</b>
                            </h6>
                            <a href="{{ route('challenge.download', ['id' => $data->id_detail, 'form' => 'pernyataan']) }}" class="btn btn-default btn-md text-white text-uppercase bg-main mt-3" onclick="zconfirmDownload(event)">
                                <b><i class="fa fa-download"></i> Download <br> Form Persetujuan</b>
                            </a>
                            <a href="{{ route('challenge.download', ['id' => $data->id_detail, 'form' => 'monitoring']) }}" class="btn btn-default btn-md text-white text-uppercase bg-main mt-3" onclick="zconfirmDownload(event)">
                                <b><i class="fa fa-download"></i> Download <br> Lembar Monitoring</b>
                            </a>
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
