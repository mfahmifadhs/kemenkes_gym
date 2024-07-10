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
                        <div class="row text-white mb-2">
                            <div class="col-md-3">
                                <img src="{{ asset('dist/img/dr_elsye.jpg') }}" alt="">
                            </div>
                            <div class="col-md-9 mt-2">
                                <h5 class="font-weight-bold">Dr. Elsye, Sp.KO</h5>
                                <h5 class="text-secondary font-weight-bold mb-3">Dokter Kedokteran Olahraga</h5>

                                <small class="text-white">
                                    dr. Elsye, Sp.KO adalah seorang Dokter Olahraga. Layanan Sports Medicine oleh dr. Elsye berfokus pada pengobatan dan pencegahan penyakit dalam dan cedera yang berhubungan dengan olahraga, serta pada pasien yang ingin meningkatkan kebugaran fisik mereka melalui program olahraga dan diet yang tepat.
                                </small>

                                <button type="submit" class="btn btn-primary btn-block">Konsul</button>
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
            title: 'Ikut Kelas?',
            text: 'Peserta yang sudah daftar kelas agar WAJIB HADIR, jika tidak hadir maka akan dikenakan penalti, yaitu tidak boleh mengikuti kelas selama 1 minggu.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
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

    function confirmCancel(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: 'Batalkan',
            text: 'Batalkan mengikuti kelas.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    }
</script>


@endsection
@endsection
