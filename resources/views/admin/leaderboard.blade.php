@extends('admin.layout.app')
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
                <div class="row">
                    <div class="col-md-3" style="overflow-y: auto; max-height: 500px;">
                        <div class="text-sm"><i class="fas fa-fire mb-4"></i> Top 10 Best Progress Fat Loss</div>
                        @foreach (collect($topFatLoss)->sortBy('progress') as $row)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5 col-4">
                                        <h5 class="bg-info text-center px-2 py-2 rounded"><b>{{ $loop->iteration }}</b></h5>
                                    </div>
                                    <div class="col-md-7 col-6 mt-2">
                                        <b>{{ $row['progress'] }} <small class="text-xs">%</small></b>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <h6 class="text-xs">
                                            {{ $row['nama'] }} <br>
                                            {{ $row['uker'] }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                    <div class="col-md-3 mx-4" style="overflow-y: auto; max-height: 500px;">
                        <div class="text-sm"><i class="fas fa-fire mb-4"></i> Top 10 Best Progress Muscle Mass</div>
                        @foreach (collect($topMuscleMass)->sortByDesc('progress') as $row)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5 col-4">
                                        <h5 class="bg-info text-center px-2 py-2 rounded"><b>{{ $loop->iteration }}</b></h5>
                                    </div>
                                    <div class="col-md-7 col-6 mt-2">
                                        <b>{{ $row['progress'] }} <small class="text-xs">%</small></b>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <h6 class="text-xs">
                                            {{ $row['nama'] }} <br>
                                            {{ $row['uker'] }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
