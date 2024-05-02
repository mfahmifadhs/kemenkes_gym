@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="section-title mb-2">
                    <h2>Hello, </h2>
                </div>

                <div class="section-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-3 text-center">
                                    <!-- <a type="button" class="btn btn-default bg-main border border-dark px-2 py-0 pt-1" data-toggle="modal" data-target="#qrcode">
                                        <i class="fa fa-qrcode fa-5x"></i>
                                    </a> -->
                                    <i class="fa fa-user-circle fa-4x text-main px-2 py-0 pt-1"></i>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h5>{{ Auth::user()->nama }}</h5>
                                    <h5>{{ Auth::user()->uker->nama_unit_kerja }}</h5>
                                </div>
                                <div class="col-md-3 col-3 text-center">
                                    <!-- <a class="btn">
                                        {!! QrCode::size(120)->generate('abc') !!}
                                    </a> -->
                                </div>
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
                        <span>Class</span>
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
                    <h2 class="px-5 pt-5 pb-4 text-main text-center">MEMBER CARD</h2>
                    <div class="text-center">
                        {!! QrCode::merge(public_path('dist/img/logo.png'), 0.5, true)
                        ->size(270)
                        ->generate(Crypt::encryptString(Auth::user()->member_id)) !!}
                    </div>
                    <h6 class="px-5 pb-4 text-white text-xs text-center" style="letter-spacing: 7px;">
                        {{ Auth::user()->member_id }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ChoseUs Section End -->

@endsection
