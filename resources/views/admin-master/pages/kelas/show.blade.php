@extends('dashboard.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <small>Class</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Class</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="row">
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-1-class-pilates.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">PILATES</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-2-class-zumba.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">ZUMBA</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-3-class-yoga.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">YOGA</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-4-class-bootcamp.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">BOOTCAMP</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-5-class-pound.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">POUNDFIT</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-6-class-running.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">RUNNING DRILS</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-7-class-bodycombat.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">BODY COMBAT</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-8-class-muaythai.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">MUAYTHAI</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-9-class-trx.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">TRX</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-10-class-liit.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">LIIT</h6>
                    </div>
                    <div class="col-md-2 col-3 text-center my-3">
                        <img src="{{ asset('dist/img/class/icon-11-class-dance.png') }}" class="img-fluid img-circle border border-dark w-75">
                        <h6 class="my-2 font-weight-bold">KPOP DANCE</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection