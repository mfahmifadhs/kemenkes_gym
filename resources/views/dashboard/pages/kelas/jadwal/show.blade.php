@extends('dashboard.layout.app')
@section('content')
<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <div class="col-12 text-left">
                        <div class="section-title mb-0">
                            <h4 class="text-main"><u>CLASS SCHEDULE</u></h4>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="schedule">
                        <div class="table-responsive mt-2 ml-0">
                            <table class="table table-bordered" style="border-collapse: separate; border-spacing: 10px;">
                                <tr>
                                    @foreach($range as $dateNumber)
                                    @php
                                    $totalKelas = $jadwal->where('hari', $dateNumber)->count();
                                    @endphp
                                    @if ($dateNumber == $today && $dateNumber >= $today)
                                    <td class="bg-white text-dark font-weight-bold text-center" style="font-size: 14px;">
                                        <h6 class="small text-uppercase">{{ $dateNumber }}</h6>
                                    </td>
                                    @else

                                    <td class="bg-main text-dark font-weight-bold text-center" style="font-size: 14px; cursor: pointer;" onclick="window.location='<?php echo route('jadwal.pilih', $dateNumber); ?>'">
                                        <h6 class="small text-uppercase">{{ $dateNumber }}</h6>
                                    </td>
                                    @endif
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            @foreach ($jadwal as $row)
                            <div class="col-md-4 col-12">
                                <div class="section-title">
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
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            @php $tanggal = Carbon\Carbon::parse($row->tanggal_kelas); @endphp
                                            <table>
                                                <tr>
                                                    <td style="width: 20%;"><img src="{{ asset('dist/img/class/'. $row->kelas->img_icon) }}" width="50"></td>
                                                    <td style="width: 60%;">
                                                        <h6 class="font-weight-bold">{{ $row->kelas->nama_kelas }}</h6>
                                                        <h6 class="small">{{ $tanggal->isoFormat('DD MMMM Y') }}</h6>
                                                        <h6 class="small">Pukul :
                                                            {{ Carbon\Carbon::parse($row->waktu_mulai)->isoFormat('HH.mm') }} s/d
                                                            {{ Carbon\Carbon::parse($row->waktu_selesai)->isoFormat('HH.mm') }}
                                                        </h6>
                                                        <h6 class="small">Kuota : {{ $totalPeserta }} / {{ $row->kuota }}</h6>
                                                        <!-- Sudah daftar di kelas ini -->
                                                        @if (Auth::user()->classActive->where('jadwal_id', $row->id_jadwal)->count() > 0)
                                                        <h6 class="text-success" style="font-size: 11px;">You're already enrolled.</h6>
                                                        @endif

                                                        <!-- Sudah daftar kelas lain di tanggal yang sama -->
                                                        @if (Auth::user()->classActive->where('tanggal_latihan', $row->tanggal_kelas)->count() > 0 && Auth::user()->classActive->where('jadwal_id', $row->id_jadwal)->count() == 0)
                                                        <h6 class="text-danger" style="font-size: 11px;">Kamu sudah terdaftar di kelas lain</h6>
                                                        @endif
                                                    </td>
                                                    <td style="width: 20%;">
                                                        @if (Auth::user()->role_id == 4 && $cekDaftar == 0 && $totalPeserta != $row->kuota && Auth::user()->classActive->where('tanggal_latihan', $row->tanggal_kelas)->count() == 0)
                                                        <a href="{{ route('jadwal.join', $row->id_jadwal) }}" class="btn btn-primary">
                                                            <i class="fa fa-hand-o-up"></i> Join
                                                        </a>
                                                        @elseif (Auth::user()->role_id == 4 && $totalPeserta == $row->kuota)
                                                        <a class="btn btn-primary text-white">
                                                            <i class="fa fa-exclamation-circle"></i> FULL
                                                        </a>
                                                        @elseif (Auth::user()->role_id == 2)
                                                        <a href="{{ route('jadwal.detail', $row->id_jadwal) }}" class="btn btn-sm bg-main text-white mt-3">
                                                            <small><i class="fa fa-info-circle"></i> Detail</small>
                                                        </a>
                                                        @else
                                                        <a href="{{ route('jadwal.join', $row->id_jadwal) }}" class="btn btn-sm bg-main text-white mt-3">
                                                            <small><i class="fa fa-info-circle"></i> Detail</small>
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr class="bg-white">
                            </div>
                            @endforeach
                        </div>

                        @if ($jadwal->count() == 0)
                        <div class="text-white mt-5" style="height: 100px;">
                            <p>Schedule not available</p>
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
