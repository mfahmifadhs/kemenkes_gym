@extends('admin-master.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <small>Hello, {{ Auth::user()->nama }}</small>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <img src="https://static.vecteezy.com/system/resources/previews/019/879/186/original/user-icon-on-transparent-background-free-png.png" class="img-fluid img-circle" alt="">
                            </div>
                            <div class="col-md-6 col-6 mt-2">
                                <p>
                                    {{ Auth::user()->nama }} <br>
                                    {{ Auth::user()->uker->nama_unit_kerja }}
                                </p>
                            </div>
                            <div class="col-md-3 col-3 text-center mt-3">
                                @if (Auth::user()->nip_nik || Auth::user()->no_telp)
                                <h6 class="small"><i>Kehadiran</i></h6>
                                <a href="" class="btn btn-default border-dark">
                                    {{ QrCode::size(70)->generate(Auth::user()->id) }}
                                </a>
                                @else
                                <a href="{{ route('member.edit', Auth::user()->id) }}" class="btn btn-info border-dark w-75">
                                    Edit
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
