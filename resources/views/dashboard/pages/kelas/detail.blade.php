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
                            <h4 class="text-main"><u>{{ $kelas->nama_kelas }}</u></h4>
                        </div>
                    </div>

                    @if (Auth::user()->role_id == 2)
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('jadwal.create', $kelas->id_kelas) }}" class="btn btn-primary">
                            <i class="fa fa-calendar"></i> Create Schedule
                        </a>
                    </div>
                    @endif
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
                    <div class="information">
                        <div class="section-title mb-0 mt-0"><span>Information</span></div>
                        <p>{!! nl2br(e($kelas->deskripsi)) !!}</p>
                    </div>
                    <div class="schedule my-5">
                        <div class="section-title mb-2">
                            <span>Schedule</span>
                        </div>

                        <div class="row">
                            @foreach ($kelas->jadwal->where('tanggal_kelas', '>=', \Carbon\Carbon::now()->format('Y-m-d')) as $row)
                            @php
                            $totalPeserta = 0;
                            $cekDaftar = 0;

                            if ($row->peserta) {
                            $totalPeserta = $row->peserta->where('tanggal_latihan', $row->tanggal_kelas)->count();
                            }

                            if ($daftar) {
                            $cekDaftar = $daftar->where('jadwal_id', $row->id_jadwal)->where('tanggal_latihan', $row->tanggal_kelas)->count();
                            }
                            @endphp
                            <div class="col-md-4 col-12">
                                <div class="card my-2">
                                    <div class="card-body">
                                        <div class="row">
                                            @php $tanggal = Carbon\Carbon::parse($row->tanggal_kelas); @endphp
                                            <div class="col-md-6 col-8">
                                                <h6><i class="fa fa-calendar"></i> {{ $tanggal->isoFormat('dddd') }}</h6>
                                                <h6>{{ $tanggal->isoFormat('DD MMMM Y') }}</h6>
                                                <h6>Pukul :
                                                    {{ Carbon\Carbon::parse($row->waktu_mulai)->isoFormat('HH.mm') }} s/d
                                                    {{ Carbon\Carbon::parse($row->waktu_selesai)->isoFormat('HH.mm') }}
                                                </h6>
                                                <h6>Kuota : {{ $totalPeserta }} / {{ $row->kuota }}</h6>

                                                @if (Auth::user()->classActive->where('jadwal_id', $row->id_jadwal)->count() > 0)
                                                <h6 class="text-success" style="font-size: 11px;">Anda sudah terdaftar.</h6>
                                                @endif
                                            </div>
                                            @if (Auth::user()->role_id == 2)
                                            <div class="col-md-6 text-right my-auto col-4 mt-2">
                                                @if ($row->tanggal_kelas >= Carbon\Carbon::now())
                                                <a href="{{ route('jadwal.edit', $row->id_jadwal) }}" class="btn btn-sm bg-main text-white mt-1">
                                                    <small><i class="fa fa-edit"></i> Edit</small>
                                                </a>
                                                @endif
                                                <a href="{{ route('jadwal.detail', $row->id_jadwal) }}" class="btn btn-sm bg-main text-white mt-1">
                                                    <small><i class="fa fa-info-circle"></i> Detail</small>
                                                </a>
                                            </div>
                                            @endif

                                            @if(Auth::user()->role_id == 4)
                                            <div class="col-md-4 col-4 text-center mt-2">

                                                @if ($cekDaftar == 0 && $totalPeserta != $row->kuota && Auth::user()->classActive->where('tanggal_latihan', $row->tanggal_kelas)->count() == 0)
                                                <a href="{{ route('jadwal.join', $row->id_jadwal) }}" class="btn btn-sm bg-main text-white mt-3">
                                                    <small><i class="fa fa-hand-o-up"></i> Join</small>
                                                </a>
                                                @elseif ($totalPeserta == $row->kuota)
                                                <a href="{{ route('jadwal.join', $row->id_jadwal) }}" class="btn btn-primary text-white">
                                                    <i class="fa fa-exclamation-circle"></i> Full
                                                </a>
                                                @else
                                                <a href="{{ route('jadwal.join', $row->id_jadwal) }}" class="btn btn-sm bg-main text-white mt-3">
                                                    <small><i class="fa fa-info-circle"></i> Detail</small>
                                                </a>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if ($kelas->jadwal->count() == 0)
                        <div class="text-white" style="height: 100px;">
                            <p>Schedule not available</p>
                            </p>
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
