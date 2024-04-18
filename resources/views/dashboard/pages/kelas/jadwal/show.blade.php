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
                                    @php $date = Carbon\Carbon::createFromFormat('d-m-Y', $dateNumber.'-'.$rangeAwal->month.'-'.$rangeAwal->year)->format('d-M-Y'); @endphp
                                    @if ($date == $today && $date >= $today)
                                    <td class="bg-white text-dark font-weight-bold text-center" style="font-size: 14px;">
                                        <h6 class="small text-uppercase">{{ $date }}</h6>
                                    </td>
                                    @else
                                    <td class="bg-main text-dark font-weight-bold text-center" style="font-size: 14px; cursor: pointer;" onclick="window.location='<?php echo route('jadwal.pilih', $date); ?>'">
                                        <h6 class="small text-uppercase">{{ $date }}</h6>
                                    </td>
                                    @endif
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        @foreach ($jadwal as $row)
                        <div class="section-title">
                            @php $totalPeserta = $row->peserta->where('tanggal_latihan', $row->tanggal_kelas)->count(); @endphp
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-3 text-center mt-2">
                                            <img src="{{ asset('dist/img/class/'. $row->kelas->img_icon) }}" width="50">
                                        </div>
                                        @php $tanggal = Carbon\Carbon::parse($row->tanggal_kelas); @endphp
                                        <div class="col-md-6 col-6">
                                            <h6 class="font-weight-bold">{{ $row->kelas->nama_kelas }}</h6>
                                            <h6 class="small">{{ $tanggal->isoFormat('DD MMMM Y') }}</h6>
                                            <h6 class="small">Pukul :
                                                {{ Carbon\Carbon::parse($row->waktu_mulai)->isoFormat('HH.mm') }} s/d
                                                {{ Carbon\Carbon::parse($row->waktu_selesai)->isoFormat('HH.mm') }}
                                            </h6>
                                            <h6 class="small">Kuota : {{ $totalPeserta }} / {{ $row->kuota }}</h6>
                                        </div>
                                        <div class="col-md-3 col-3 text-center">
                                            @if ($totalPeserta != $row->kuota)
                                            <a href="{{ route('jadwal.join', $row->id_jadwal) }}" class="btn btn-primary">
                                                <i class="fa fa-hand-o-up"></i> JOIN
                                            </a>
                                            @else
                                            <a class="btn btn-primary text-white">
                                                <i class="fa fa-exclamation-circle"></i> FULL
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="bg-white">
                        @endforeach

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
