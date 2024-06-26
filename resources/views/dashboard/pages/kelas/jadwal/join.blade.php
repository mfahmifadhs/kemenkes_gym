@extends('dashboard.layout.app')
@section('content')

@php
$isPenalty    = Auth::user()->penalty->where('kelas_id', $jadwal->kelas_id)->count();
$totalPeserta = $jadwal->peserta->where('tanggal_latihan', $jadwal->tanggal_kelas)->count();
$terdaftar    = $jadwal->peserta->where('member_id', Auth::user()->id)->count();
$waktuSelesai = Carbon\Carbon::parse($jadwal->tanggal_kelas . ' ' . $jadwal->waktu_selesai)
@endphp

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>JOIN {{ $jadwal->kelas->nama_kelas }}</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('kelas.detail', $jadwal->kelas_id) }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
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
                @endif

                @if ($message = Session::get('failed'))
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

                <div class="section-body mb-5">
                    <div class="schedule p-3" style="border: 1px solid #00b9ad;">
                        <div class="section-title mb-2">
                            <span>Join Class</span>
                        </div>
                        <div class="row text-white mb-2">
                            <label class="col-md-3 col-3">Class</label>
                            <div class="col-md-9 col-9">: {{ $jadwal->kelas->nama_kelas }}</div>
                            <label class="col-md-3 col-3">Date</label>
                            <div class="col-md-9 col-9">: {{ Carbon\Carbon::parse($jadwal->tanggal_kelas)->format('l / d F Y') }}</div>
                            <label class="col-md-3 col-3">Time</label>
                            <div class="col-md-9 col-9">: {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H.i') }} s/d {{ Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H.i') }}</div>
                            <label class="col-md-3 col-3">Trainer</label>
                            <div class="col-md-9 col-9">: {{ $jadwal->nama_pelatih }}</div>
                            <label class="col-md-3 col-3">Kuota</label>
                            <div class="col-md-9 col-9">: {{ $totalPeserta }} / {{ $jadwal->kuota }}</div>
                            <label class="col-md-3 col-3">Location</label>
                            <div class="col-md-9 col-9">: {{ $jadwal->lokasi }}</div>
                        </div>

                        @if(Auth::user()->role_id == 4 && Carbon\Carbon::now() <= $waktuSelesai)
                            @if (!$isPenalty && $daftar?->count() == 0 && $totalPeserta != $jadwal->kuota)
                                @if (Carbon\Carbon::now() >= $tglBuka && Carbon\Carbon::now()->format('H:i') >= $jamBuka)
                                <form id="form" action="{{ route('jadwal.join', $jadwal->id_jadwal) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="member_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="tanggal_latihan" value="{{ $jadwal->tanggal_kelas }}">
                                    <input type="hidden" name="kuota" value="{{ $jadwal->kuota }}">
                                    <button type="submit" class="btn btn-primary btn-block" onclick="confirmSubmit(event)">
                                        JOIN
                                    </button>
                                </form>
                                @endif
                            @elseif ($totalPeserta == $jadwal->kuota)
                                @if ($terdaftar == 0 || $pembatalan == 'false')
                                <a href="" class="btn btn-danger btn-block text-uppercase font-weight-bold disabled">Full</a>
                                @else
                                <form id="form" action="{{ route('jadwal.cancel', $jadwal->id_jadwal) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="member_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="tanggal_latihan" value="{{ $jadwal->tanggal_kelas }}">
                                    <button type="submit" class="btn btn-danger btn-block" onclick="confirmCancel(event)">
                                        <i class="fa fa-times"></i> Batal
                                    </button>
                                </form>
                                @endif
                            @elseif ($isPenalty)
                            <div class="bg-danger rounded p-2 text-white text-center">
                                <small><b>Anda sedang masa penalti & tidak dapat mengikuti kelas selama 7 hari.</b></small>
                            </div>
                            @else
                                @if ($pembatalan == 'true')
                                <form id="form" action="{{ route('jadwal.cancel', $jadwal->id_jadwal) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="member_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="tanggal_latihan" value="{{ $jadwal->tanggal_kelas }}">
                                    <button type="submit" class="btn btn-danger btn-block" onclick="confirmCancel(event)">
                                        <i class="fa fa-times"></i> Batal
                                    </button>
                                </form>
                                @else
                                <div class="bg-success rounded p-2 text-white text-center">
                                    <small><b>Anda sudah terdaftar</b></small>
                                </div>
                                @endif
                            @endif
                            @endif

                            <div class="section-title mb-2">
                                <span>Notes</span>
                            </div>

                            <span class="text-white small">{!! nl2br(e($jadwal->kelas->deskripsi)) !!}</span>

                            <div class="section-title mb-2">
                                <span>Members Joined ({{ $totalPeserta }})</span>
                            </div>

                            @if ($totalPeserta == 0)
                            <span class="text-white">No members have joined yet</span>
                            @else
                            <div class="row">
                                @foreach ($jadwal->peserta as $row)
                                <div class="col-md-3 col-6">
                                    <div class="card text-center form-group">
                                        <div class="card-header">
                                            <i class="fa fa-user-circle fa-3x"></i>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="small">{{ $row->created_at }}</h6>
                                            <h6 class="small">{{ ucwords(strtolower($row->member->nama)) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@section('js')
<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: 'Ikut Kelas?',
            text: 'Peserta yang sudah daftar kelas agar WAJIB HADIR, jika tidak hadir maka akan dikenakan penalti, yaitu tidak boleh mengikuti kelas selama 1 minggu.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    }

    function confirmCancel(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: 'Batalkan',
            text: 'Batalkan mengikuti kelas.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    }
</script>


@endsection
@endsection
