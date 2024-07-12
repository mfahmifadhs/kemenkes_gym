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

                                    <small class="text-white">{{ $dokter->profil_dokter }}</small>

                                    @if (Auth::user()->konsul->where('konsultasi', false)->count() != 1)
                                    <button type="submit" onclick="confirmSubmit(event)" class="btn btn-primary btn-block">Konsul</button>
                                    @else
                                    <a href="{{ route('konsul.cancel') }}" onclick="confirmCancel(event)" class="btn btn-danger btn-sm mt-2 btn-block">
                                        Batalkan
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        @if (Auth::user()->konsul->count() == 1 || Auth::user()->konsul->where('konsultasi', false)->count() == 1)
                        <div class="row">
                            <div class="col-md-3">
                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-danger"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Tes Vo2Max SIPGAR</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-secondary"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Tes Fitness</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-secondary"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Konsul Dokter</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (Auth::user()->konsul->where('test_sipgar', false)->count() == 1 && Auth::user()->konsul->where('test_fitness', false)->count() == 1)
                            <div class="col-md-9 col-12 mt-5">
                                <div class="vertical-line"></div>
                                <h4 class="text-white ml-4 text-uppercase">Mohon untuk melakukan Tes Vo2Max SIPGAR & Tes Fitness</h4>
                                <h6 class="text-secondary ml-4">untuk melakukan tes silahkan hubungi Coach untuk mengatur jadwal.</h6>

                                <div class="input-group ml-4">
                                    <a href="https://api.whatsapp.com/send?phone=+{{ $phone }}&text={{ $msg }}" target="_blank" class="btn btn-primary btn-sm">
                                        Hubungi Coach
                                    </a>
                                </div>
                            @endif

                            @if (Auth::user()->konsul->where('test_sipgar', true)->count() == 1 && Auth::user()->konsul->where('test_fitness', true)->count() == 1)
                                <div class="vertical-line"></div>
                                <label class="text-success text-sm ml-4 font-weight-bold">Berikut jadwal konsultasi anda:</label> <br>
                                <label class="text-white ml-4">
                                    <span><i class="fa fa-calendar"></i> Jum'at, 12 Juni 2024</span>
                                </label> <br>

                                <label class="text-white ml-4">
                                    <span><i class="fa fa-clock-o"></i> 08.00 WIB s/d 08.30 WIB</span>
                                </label> <br>

                                <label class="text-white ml-4 mt-4">
                                    <span><i class="fa fa-pencil"></i> Catatan Dokter: </span>
                                </label>
                            </div>
                            @endif
                        </div>
                        @endif

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
</script>


@endsection
@endsection
