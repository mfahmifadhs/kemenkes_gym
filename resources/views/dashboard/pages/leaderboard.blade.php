@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-12 mx-auto">
                <div class="row mt-5">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>Leaderboard</u></h4>
                        </div>
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
                @elseif ($message = Session::get('failed'))
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

                <div class="section-body">
                    <div class="information text-justify">
                        <div class="row">
                            <div class="col-md-3" style="overflow-y: auto; max-height: 500px;">
                                <h6 class="text-main mb-0 mt-0"><i class="fa fa-fire mb-4"></i> Top 10 Best Progress Fat Loss</h6>
                                @foreach (collect($topFatLoss)->sortBy('progress') as $row)
                                <div class="card form-group">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5 col-4">
                                                <h5 class="bg-main text-center px-2 py-2 rounded"><b>{{ $loop->iteration }}</b></h5>
                                            </div>
                                            <div class="col-md-7 col-6 mt-2">
                                                <h5>{{ $row['progress'] }} <small class="text-xs">{{ $row['satuan'] }}</small></h5>
                                            </div>
                                            <div class="col-md-12 col-12 mt-1">
                                                <h6 class="text-xs small">
                                                    {{ $row['nama'] }} <br>
                                                    {{ $row['uker'] }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>


                            <div class="col-md-3" style="overflow-y: auto; max-height: 500px;">
                                <h6 class="text-main mb-0 mt-0"><i class="fa fa-fire mb-4"></i> Top 10 Best Progress Muscle Mass</h6>
                                @foreach (collect($topMuscleMass)->sortByDesc('progress') as $row)
                                <div class="card form-group">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5 col-4">
                                                <h5 class="bg-main text-center px-2 py-2 rounded"><b>{{ $loop->iteration }}</b></h5>
                                            </div>
                                            <div class="col-md-7 col-6 mt-2">
                                                <h5>{{ $row['progress'] }} <small class="text-xs">{{ $row['satuan'] }}</small></h5>
                                            </div>
                                            <div class="col-md-12 col-12 mt-1">
                                                <h6 class="text-xs small">
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

    </div>
</section>
<!-- ChoseUs Section End -->

@endsection
