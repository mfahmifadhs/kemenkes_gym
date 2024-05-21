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
                    <h2>Hello, </h2>
                </div>

                <div class="section-body">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-md-3 col-2 text-center">
                                    <a type="button" href="{{ route('member.qrcode') }}" class="btn btn-default bg-main border border-dark px-2 py-0 pt-1">
                                        <i class="fa fa-qrcode fa-4x text-dark"></i>
                                    </a>
                                    <!-- <a type="button" class="btn btn-default bg-main border border-dark px-2 py-0 pt-1" data-toggle="modal" data-target="#qrcode">
                                        <i class="fa fa-qrcode fa-5x"></i>
                                    </a> -->
                                    <!-- <i class="fa fa-user-circle fa-4x text-main px-2 py-0 pt-1"></i> -->
                                </div>
                                <div class="col-md-6 col-6">
                                    <h6 class="ml-3">{{ Auth::user()->nama }}</h6>
                                    <h6 class="ml-3">{{ Auth::user()->instansi != 'pusat' ? Auth::user()->nama_instansi : Auth::user()->uker->nama_unit_kerja }}</h6>
                                </div>
                                @if(Auth::user()->absen->where('waktu_keluar', null)->count() != 0)
                                <div class="col-md-3 col-4 text-center my-auto">
                                    <a href="" class="btn btn-sm bg-main text-white mt-1" onclick="confirm(event, `{{ route('absen.checkout', Auth::user()->id) }}`)">
                                        <small><i class="fa fa-sign-out"></i> Check out</small>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-header">
                    <div class="row mt-2">
                        <a href="{{ route('bodyck') }}" class="col-md-2 col-6">
                            <div class="card bg-main">
                                <div class="card-body text-dark text-center font-weight-bold p-2 small">
                                    <i class="fa fa-heartbeat"></i> Body Check
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('progres') }}" class="col-md-2 col-6">
                            <div class="card bg-main">
                                <div class="card-body text-dark text-center font-weight-bold p-2 small">
                                    <i class="fa fa-universal-access"></i> Progress
                                </div>
                            </div>
                        </a>
                    </div>
                </div>



                <div class="section-menu my-5">
                    <div class="section-title mb-2">
                        <h6 class="text-main mb-0 mt-0">Daftar Kelas</h6>
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
                            <h6 class="text-main mb-3 mt-0">Kelas Diikuti</h6>
                        </div>
                        @foreach (Auth::user()->classActive->where('tanggal_latihan', '>', \Carbon\Carbon::now()) as $row)
                        <div class="col-md-3 form-group">
                            <a href="{{ route('jadwal.join', $row->jadwal_id) }}">
                                <div class="card">
                                    <div class="card-body text-dark font-weight-bold p-2 small">
                                        {{ $row->jadwal->tanggal_kelas }} <br>
                                        {{ $row->jadwal->kelas->nama_kelas }} <br>
                                        {{ \Carbon\Carbon::parse($row->jadwal->waktu_mulai)->format('H:m') }} - {{ \Carbon\Carbon::parse($row->jadwal->waktu_selesai)->format('H:m') }} <br>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- <div class="section-menu my-5">
                    <div class="section-title mb-5">
                        <span>My Class Active</span>
                    </div>
                    <div class="menu-group">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
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
