@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">

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

                <div class="section-title mb-2">
                    <div class="input-group">
                        <img src="https://cdn-icons-png.flaticon.com/128/149/149071.png" width="50">
                        <h6 class="ml-2 mt-1 text-white">Welcome Back, <br> {{ Auth::user()->nama }}</h6>
                    </div>
                </div>

                <div class="section-body">
                    <div class="card bg-main mb-3" style="border-radius: 20px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8 my-auto">
                                    <h6 class="text-white">KELAS <b>ZUMBA</b> SEGARA DIMULAI</h6>
                                    <h4 class="text-white font-weight-bold mt-1">
                                        <a href="{{ route('kelas.detail', 2) }}"><u>DAFTAR SEKARANG!</u></a>
                                    </h4>
                                    <span style="font-size: 10px; color: red;"><b>Kuota terbatas</b></span>
                                    <!-- <h3 class="text-white"><b>COMING SOON!</b></h3> -->
                                </div>
                                <div class="col-4 text-center">
                                    @if(Auth::user()->absen->where('waktu_keluar', null)->count() == 0)
                                    <a type="button" href="{{ route('member.qrcode') }}" class="btn btn-default bg-white border border-dark px-2 py-0 pt-1">
                                        <i class="fa fa-qrcode fa-4x text-dark"></i>
                                        <h6 class="small mb-1">Member Card</h6>
                                    </a>
                                    @else
                                    <a href="" class="btn btn-sm bg-white text-main mt-1" onclick="confirm(event, `{{ route('absen.checkout', Auth::user()->id) }}`)">
                                        <small><i class="fa fa-sign-out"></i> Check out</small>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-header">
                    <div class="row">
                        <!-- <a href="{{ route('absen.show') }}" class="col-md-2 col-6 mt-2">
                            <div class="card bg-main">
                                <div class="card-body text-dark text-center font-weight-bold p-2 small">
                                    <i class="fa fa-calendar"></i> Attendance
                                </div>
                            </div>
                        </a> -->
                        <a href="{{ route('bodyck') }}" class="col-md-3 col-6">
                            <div class="card bg-main" style="border-radius: 20px;">
                                <div class="card-body text-white text-center font-weight-bold p-2 small">
                                    <i class="fa fa-heartbeat"></i> Body Composition
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('progres') }}" class="col-md-3 col-6">
                            <div class="card bg-main" style="border-radius: 20px;">
                                <div class="card-body text-white text-center font-weight-bold p-2 small">
                                    <i class="fa fa-fire"></i> My Workout
                                </div>
                            </div>
                        </a>
                        <!-- <a href="{{ route('progres') }}" class="col-md-2 col-6">
                            <div class="card bg-main" style="border-radius: 20px;">
                                <div class="card-body text-white text-center font-weight-bold p-2 small">
                                    <i class="fa fa-bar-chart"></i> Progress
                                </div>
                            </div>
                        </a> -->
                    </div>
                </div>



                <div class="section-menu my-5">
                    <div class="section-title mb-2">
                        <h6 class="text-white mb-0 mt-0">Class</h6>
                    </div>
                    <div class="container menu-group">
                        <div class="row text-center flex-nowrap">
                            @foreach ($kelas as $row)
                            <div class="col-sm-2 col-4">
                                <a href="{{ route('kelas.detail', $row->id_kelas) }}">
                                    <img src="{{ asset('dist/img/class/'. $row->img_icon) }}" class="text-primary img-circle">
                                    <h6 class="title">
                                        {{ $row->id_kelas != 10 ? $row->nama_kelas : 'LIIT' }}
                                    </h6>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="section-header">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <h6 class="text-white mb-3 mt-0">Class Today</h6>
                            @if ($jadwal->count() == 0)
                            <small class="text-white">No class today</small>
                            @endif
                        </div>
                        @foreach ($jadwal as $row)
                        @php
                        if ($row->peserta) {
                        $totalPeserta = $row->peserta->where('tanggal_latihan', $row->tanggal_kelas)->count();
                        }
                        @endphp
                        <div class="col-md-5 form-group">
                            <a href="{{ route('jadwal.join', $row->id_jadwal) }}">
                                <div class="card p-1" style="border-radius: 20px;">
                                    <div class="card-body text-dark font-weight-bold p-2 small">
                                        <div class="row">
                                            <div class="col-md-8 col-9">
                                                <div class="input-group">
                                                    <img src="{{ asset('dist/img/class/'. $row->kelas->img_icon) }}" width="58">
                                                    <h6 class="ml-2 mt-1">
                                                        {{ $row->kelas->nama_kelas }} <br>
                                                        <small>{{ \Carbon\Carbon::parse($row->tanggal_kelas)->isoFormat('DD MMMM Y') }} |
                                                            {{ \Carbon\Carbon::parse($row->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($row->waktu_selesai)->format('H:i') }}
                                                        </small> <br>
                                                        @if (Auth::user()->classActive->where('jadwal_id', $row->id_jadwal)->count() > 0)
                                                        <span class="text-success" style="font-size: 11px;">You're already enrolled.</span>
                                                        @endif
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-3 text-center mt-2">
                                                <h6 class="small">Kuota</h6>
                                                <h6>{{ $totalPeserta }} / {{ $row->kuota }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('jadwal.join', $row->id_jadwal) }}" class="btn btn-sm bg-main text-white mt-3" style="border-radius: 20px;">
                                        <small><i class="fa fa-info-circle"></i> Detail</small>
                                    </a>
                                </div>
                            </a>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Member Card -->
<div class="modal fade" id="qrcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SCAN HERE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="bg-dark rounded">
                    <h4 class="px-5 pt-5 pb-4 text-main text-xs text-center">MEMBER CARD</h4>
                    <div class="text-center pb-4">
                        {!! QrCode::merge(public_path('dist/img/logo.png'), 0.5, true)
                        ->size(270)
                        ->generate(Auth::user()->member_id) !!}
                    </div>
                    <!-- <h6 class="px-5 pb-4 text-white text-xs text-center" style="letter-spacing: 7px;">
                        {{ Auth::user()->member_id }}
                    </h6> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ChoseUs Section End -->

@section('js')
<script>
    function confirm(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Selesai Latihan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });

    }
</script>
@endsection

@endsection
