@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row mb-2">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>BODY CHECK</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('bodyck.create') }}" class="btn btn-primary">
                            <i class="fa fa-heartbeat"></i> Create Progress
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
                    <div class="schedule">
                        <div class="section-title mb-2"><span>Body Check Result</span></div>
                        @foreach ($bodyck as $i => $row)
                        <div class="card my-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-2 text-center mt-2">
                                        <h6 class="fa-1x">{{ $loop->iteration }}</h6>
                                    </div>
                                    @php $tanggal = Carbon\Carbon::parse($row->tanggal_cek); @endphp
                                    <div class="col-md-6 col-6">
                                        <h6>{{ $tanggal->isoFormat('DD-MM-Y HH:mm') }}</h6>
                                        <small>SERIAL NO. {{ str_pad($row->no_serial, 8, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                    <div class="col-md-3 col-4 text-center">
                                        <a href="{{ route('bodyck.detail', $row->id_bodyck) }}" class="btn btn-primary mt-0 p-2">
                                            <i class="fa fa-info-circle fa-2x"></i>
                                        </a>
                                        <a href="{{ route('bodyck.edit', $row->id_bodyck) }}" class="btn btn-primary mt-0 p-2">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($i == 0)
                        <hr class="divider">
                        @endif
                        @endforeach
                        @if ($bodyck->count() == 0)
                        <div class="text-white" style="height: 100px;">
                            <p>Data not available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@endsection
