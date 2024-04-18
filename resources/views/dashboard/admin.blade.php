@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="section-title mb-2">
                    <h2>Hello, {{ Auth::user()->nama }}</h2>
                </div>

                <div class="section-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-3 text-center">
                                    <i class="fa fa-user-circle fa-5x"></i>
                                </div>
                                <div class="col-md-6 col-6">
                                    <h5>{{ Auth::user()->nama }}</h5>
                                    <h5>{{ Auth::user()->uker->nama_unit_kerja }}</h5>
                                </div>
                                <div class="col-md-3 col-3 text-center">
                                    <a class="btn btn-primary mt-3">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-menu my-5">
                    <div class="section-title mb-2">
                        <span>Class</span>
                    </div>
                    <div class="container menu-group">
                        <div class="row text-center flex-nowrap">
                            @foreach ($kelas as $row)
                            <div class="col-sm-2 col-3">
                                <a href="{{ route('kelas.detail', $row->id_kelas) }}">
                                    <img src="{{ asset('dist/img/class/'. $row->img_icon) }}" class="text-primary w-100 img-circle">
                                    <h6 class="title">
                                        {{ $row->id_kelas != 10 ? $row->nama_kelas : 'LIIT' }}
                                    </h6>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@endsection
