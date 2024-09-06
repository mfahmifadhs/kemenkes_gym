@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-8 col-12 mx-auto">
            <div class="row mb-2">
                <div class="col-sm-12 col-12 mb-2">
                    <h1 class="m-0 text-lg">Fat Loss & Muscle Gain Challenge</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('challenge') }}">Challenge</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                    @if ($message = Session::get('success'))
                    <div id="alert" class="alert bg-success">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>

                    <script>
                        setTimeout(function() {
                            document.getElementById('alert').style.display = 'none';
                        }, 10000);
                    </script>
                    @endif
                    <div class="card border border-dark mt-3">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-3 text-center mt-5">
                                    @if ($challenge->challenge_id == 1)
                                    <img src="{{ asset('dist/img/challenge/fatloss.png') }}" class="img-fluid w-50" alt="">
                                    @else
                                    <img src="{{ asset('dist/img/challenge/musclegain.png') }}" class="img-fluid w-50" alt="">
                                    @endif

                                    @php
                                    $first = $bodyCp?->first();
                                    $last = $bodyCp?->last();
                                    @endphp
                                </div>
                                <div class="col-md-9 col-12">
                                    <h5 class="font-weight-bold text-secondary">
                                        Challenge <br>
                                        <small class="text-warning"><b>{{ $challenge->challenge->nama_challenge }}</b></small>
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group small">
                                                <label style="width: 15%;">Member ID</label>
                                                <label style="width: 85%;">: {{ $challenge->member->member_id }}</label>
                                            </div>
                                            <div class="input-group small">
                                                <label style="width: 15%;">Nama Peserta</label>
                                                <label style="width: 85%;">: {{ $challenge->member->nama }}</label>
                                            </div>
                                            <div class="input-group small">
                                                <label style="width: 15%;">Asal</label>
                                                <label style="width: 85%;">:
                                                    {{ $challenge->member->uker ? $challenge->member->uker->nama_unit_kerja : $challenge->member->nama_instansi }}
                                                </label>
                                            </div>
                                            <div class="input-group small">
                                                <label style="width: 15%;">Kategori</label>
                                                <label style="width: 85%;">:
                                                    {{ $challenge->member->jenis_kelamin == 'male' ? 'Pria' : 'Wanita' }}
                                                    {{ $challenge->challenge->nama_challenge }}
                                                </label>
                                            </div>
                                            @if ($challenge->challenge_id == 1)
                                            <div class="input-group small">
                                                <label style="width: 15%;">Fat Loss</label>
                                                <label style="width: 85%;">:
                                                    {{ ($first?->fatp - $last?->fatp) < 0 ? '+' : '-' }} {{ abs($first?->fatp - $last?->fatp) }} %
                                                </label>
                                            </div>
                                            @else
                                            <div class="input-group small">
                                                <label style="width: 15%;">Muscle Gain</label>
                                                <label style="width: 85%;">:
                                                    {{ ($first?->pmm - $last?->pmm) < 0 ? '+' : '-' }} {{ number_format(abs($last?->pmm - $first?->pmm), 1) }} kg
                                                </label>
                                            </div>
                                            @endif
                                            <div class="input-group small">
                                                <label style="width: 15%;">Kategori</label>
                                                <label style="width: 85%;">: {{ $challenge->member->jenis_kelamin == 'male' ? 'Pria' : 'Wanita' }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-12">
                                    <small>
                                        <label class="mt-4"><b>Tahapan Penimbangan: </b></label> <br>
                                        <span class="{{ Carbon\Carbon::now() > '2024-08-13' }} ? 'bg-danger' : '' }}">
                                            1. Tahap 1 : 5 Agustus 2024 - 9 Agustus 2024
                                        </span><br>
                                        2. Tahap 2 : 2 September 2024 - 6 September 2024 <br>
                                        3. Tahap 3 : 1 Oktober 2024 - 4 Oktober 2024 <br>
                                        4. Tahap 4 : 28 Oktober 2024 - 31 Oktober 2024 <br>
                                    </small>
                                </div>
                                <div class="col-md-7 col-12">
                                    <small>
                                        <label class="mt-4"><b>Hadiah: </b></label> <br>
                                        1. Mendapatkan loker khusus selama 3 bulan. <br>
                                        2. Plakat pemenang <i>challenge</i>. <br>
                                        3. <i>Free whey protein</i> dan <i>fitness supplement</i>. <br>
                                        4. Bebas mengikuti kelas selama 3 bulan (tanpa join kelas). <br>
                                        5. Pemenang challenge akan diumumkan di hari kesehatan Nasional.
                                    </small>
                                </div>

                                <div class="col-md-12 col-12 mt-3">
                                    <label class="small"><b>Progres Penimbangan: </b></label> <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center small">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>AKSI</th>
                                                    <th>DATE</th>
                                                    <th>TIME</th>
                                                    <th>HEIGHT</th>
                                                    <th>CLOTHES</th>
                                                    <th>WEIGHT</th>
                                                    <th>FAT</th>
                                                    <th>MUSCLE&nbsp;MASS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bodyCp as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a href="" onclick="confirmRemove(event, `{{ route('challenge.tanita.delete', $row->id_bodycp) }}`)">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $row->tanggal_cek)->isoFormat('DD MMM Y') }}</td>
                                                    <td>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $row->tanggal_cek)->isoFormat('HH:mm') }}</td>
                                                    <td>{{ $row->height }} cm</td>
                                                    <td>{{ $row->clothes }} kg</td>
                                                    <td>{{ $row->weight }} kg</td>
                                                    <td>{{ $row->fatp }} %</td>
                                                    <td>{{ $row->pmm }} kg</td>
                                                </tr>
                                                @endforeach

                                                <!-- Hasil Selisih -->
                                                @if ($bodyCp->count() != 0)
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td>{{ ($first->weight - $last->weight) < 0 ? '+' : '-' }} {{ abs($first->weight - $last->weight) }} kg</td>
                                                    <td>{{ ($first->fatp - $last->fatp) < 0 ? '+' : '-' }} {{ abs($first->fatp - $last->fatp) }} %</td>
                                                    <td>{{ ($first->pmm - $last->pmm) < 0 ? '+' : '-' }} {{ number_format(abs($last->pmm - $first->pmm), 1) }} kg</td>
                                                </tr>
                                                @endif

                                                @if (!$bodyCp->count())
                                                <tr>
                                                    <td colspan="16">data not available</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    function confirmRemove(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus',
            text: 'Hapus Data',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection
@endsection
