@extends('admin.layout.app')
@section('content')

@php
$cekHari = Carbon\Carbon::parse($id)->isoFormat('dddd');
$cekWarna = $cekHari == 'Kamis' ? 'bg-pink' : 'bg-main';
@endphp


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-9">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Schedule</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('jadwal.createByDate', $id) }}" class="btn btn-primary btn-sm bg-main">
                        <i class="fas fa-circle-plus"></i> Tambah Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-9">
            <div class="table-responsive mt-2 ml-0">
                <table class="table table-bordered" style="border-collapse: separate; border-spacing: 10px;">
                    <tr>
                        @foreach($range as $dateNumber)
                        @php
                        $totalKelas = $jadwal->where('hari', $dateNumber)->count();
                        $totalHari = Carbon\Carbon::parse($dateNumber)->isoFormat('dddd');
                        $warnaHari = $totalHari == 'Kamis' ? 'bg-pink' : 'bg-main';
                        @endphp
                        @if ($dateNumber == $today)
                        <td class="bg-white text-dark font-weight-bold text-center" style="font-size: 14px;">
                            <h6 class="small text-uppercase pt-2 font-weight-bold">{{ $dateNumber }}</h6>
                        </td>
                        @else
                        <td class="{{ $warnaHari }} text-white font-weight-bold text-center" style="font-size: 14px; cursor: pointer;" onclick="window.location='<?php echo route('jadwal.pilih', $dateNumber); ?>'">
                            <h6 class="small text-uppercase pt-2 font-weight-bold">{{ $dateNumber }}</h6>
                        </td>
                        @endif
                        @endforeach
                    </tr>
                </table>
            </div>
            <hr>


            @if ($cekHari == 'Kamis')
            <div class="mt-3">
                <h5 class="text-pink">Ladies Day</h5>
                <small>Setiap hari <b>Kamis</b> Kemenkes Bootcamp & Fitness Center hanya untuk <b>Wanita</b></small>
            </div>
            @endif

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
                            <div class="card-body p-2">
                                @php $tanggal = Carbon\Carbon::parse($row->tanggal_kelas); @endphp
                                <div class="row">
                                    <div class="col-md-3 col-3 text-center my-auto">
                                        @if ($cekHari == 'Kamis')
                                        <img src="{{ asset('dist/img/class/'. $row->kelas->img_icon) }}" width="50" class="bg-pink" style="border-radius: 50%; padding: 5px;">
                                        @else
                                        <img src="{{ asset('dist/img/class/'. $row->kelas->img_icon) }}" width="50">
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <h6 class="font-weight-bold"></h6>
                                        <h6>
                                            <b> {{ $row->kelas->nama_kelas }} </b> <br>
                                            <small>
                                                {{ $tanggal->isoFormat('DD MMMM Y') }} <br>
                                                Pukul :
                                                {{ Carbon\Carbon::parse($row->waktu_mulai)->isoFormat('HH.mm') }} s/d
                                                {{ Carbon\Carbon::parse($row->waktu_selesai)->isoFormat('HH.mm') }} <br>
                                                Kuota : {{ $totalPeserta }} / {{ $row->kuota }}
                                            </small>
                                        </h6>
                                        <h6 class="small">
                                        </h6>
                                        <h6 class="small"></h6>
                                        <!-- Sudah daftar di kelas ini -->
                                        @if (Auth::user()->classActive->where('jadwal_id', $row->id_jadwal)->count() > 0)
                                        <h6 class="text-success" style="font-size: 11px;">Anda sudah terdaftar</h6>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-3 my-auto">
                                        <a href="{{ route('jadwal.detail', $row->id_jadwal) }}" class="btn btn-sm {{ $cekWarna }} text-white w-100">
                                            <small><i class="fa fa-info-circle"></i> Detail</small>
                                        </a>
                                        <a href="{{ route('jadwal.edit', $row->id_jadwal) }}" class="btn btn-sm {{ $cekWarna }} w-100 text-white mt-2">
                                            <small><i class="fa fa-edit"></i> Edit</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="bg-white">
                </div>
                @endforeach
            </div>

            @if ($jadwal->count() == 0)
            <div class="mt-2" style="height: 100px;">
                <p>Jadwal tidak tersedia</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
