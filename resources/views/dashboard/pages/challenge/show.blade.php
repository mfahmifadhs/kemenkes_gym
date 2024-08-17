@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row mt-5">
                    <div class="col-7 text-left">
                        <div class="section-title">
                            <h3 class="text-main">
                                <u><i class="fa fa-trophy fa-2x"></i> CHALLENGE</u>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="schedule p-3 border-main">
                        <div class="row text-white mb-2">
                            <div class="col-md-3 text-center mt-5">
                                @if ($challenge->challenge_id == 1)
                                <img src="{{ asset('dist/img/challenge/fatloss.png') }}" alt="">
                                @else
                                <img src="{{ asset('dist/img/challenge/musclegain.png') }}" alt="">
                                @endif

                                @php
                                $first = $bodyCp->first();
                                $last = $bodyCp->last();
                                @endphp
                            </div>
                            <div class="col-md-9 col-12">
                                <h6 class="font-weight-bold mt-2 text-secondary">Challenge</h6>
                                <h5 class="text-secondary font-weight-bold mb-3 text-warning">{{ $challenge->challenge->nama_challenge }}</h5>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group small">
                                            <label style="width: 20%;">Nama Peserta</label>
                                            <label style="width: 80%;">: {{ $challenge->member->nama }}</label>
                                        </div>
                                        <div class="input-group small">
                                            <label style="width: 20%;">Asal</label>
                                            <label style="width: 80%;">:
                                                {{ $challenge->member->uker ? $challenge->member->uker->nama_unit_kerja : $challenge->member->nama_instansi }}
                                            </label>
                                        </div>
                                        <div class="input-group small">
                                            <label style="width: 20%;">Kategori</label>
                                            <label style="width: 80%;">:
                                                {{ $challenge->member->jenis_kelamin == 'male' ? 'Pria' : 'Wanita' }}
                                                {{ $challenge->challenge->nama_challenge }}
                                            </label>
                                        </div>
                                        @if ($challenge->challenge_id == 1)
                                        <div class="input-group small">
                                            <label style="width: 20%;">Fat Loss</label>
                                            <label style="width: 80%;">:
                                                {{ ($first->fatp - $last->fatp) < 0 ? '+' : '-' }} {{ abs($first->fatp - $last->fatp) }} %
                                            </label>
                                        </div>
                                        @else
                                        <div class="input-group small">
                                            <label style="width: 20%;">Muscle Gain</label>
                                            <label style="width: 80%;">:
                                                {{ ($first->pmm - $last->pmm) < 0 ? '+' : '-' }} {{ number_format(abs($last->pmm - $first->pmm), 1) }} kg
                                            </label>
                                        </div>
                                        @endif
                                        <div class="input-group small">
                                            <label style="width: 20%;">Kategori</label>
                                            <label style="width: 80%;">: {{ $challenge->member->jenis_kelamin == 'male' ? 'Pria' : 'Wanita' }}</label>
                                        </div>
                                        <label class="text-danger small">
                                            Jika anda tidak melakukan penimbangan sesuai jadwal, maka anda akan didiskualifikasi.
                                        </label>
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
                                    <table class="table table-bordered text-white text-center small">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>DATE</th>
                                                <th>TIME</th>
                                                <th>HEIGHT</th>
                                                <th>CLOTHES</th>
                                                <th>WEIGHT</th>
                                                @if ($challenge->challenge_id == 1)
                                                <th>FAT</th>
                                                @else
                                                <th>MUSCLE&nbsp;MASS</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bodyCp as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $row->tanggal_cek)->isoFormat('DD MMM Y') }}</td>
                                                <td>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $row->tanggal_cek)->isoFormat('HH:mm') }}</td>
                                                <td>{{ $row->height }} cm</td>
                                                <td>{{ $row->clothes }} kg</td>
                                                <td>{{ $row->weight }} kg</td>
                                                @if ($challenge->challenge_id == 1)
                                                <td>{{ $row->fatp }} %</td>
                                                @else
                                                <td>{{ $row->pmm }} kg</td>
                                                @endif
                                            </tr>
                                            @endforeach

                                            <!-- Hasil Selisih -->
                                            @if ($bodyCp->count() != 0)
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>{{ ($first->height - $last->height) < 0 ? '+' : '-' }} {{ abs($first->height - $last->height) }} cm</td>
                                                <td></td>
                                                <td>{{ ($first->weight - $last->weight) < 0 ? '+' : '-' }} {{ abs($first->weight - $last->weight) }} kg</td>
                                                @if ($challenge->challenge_id == 1)
                                                <td>{{ ($first->fatp - $last->fatp) < 0 ? '+' : '-' }} {{ abs($first->fatp - $last->fatp) }} %</td>
                                                @else
                                                <td>{{ ($first->pmm - $last->pmm) < 0 ? '+' : '-' }} {{ number_format(abs($last->pmm - $first->pmm), 1) }} kg</td>
                                                @endif
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
</section>
<!-- ChoseUs Section End -->

@endsection
