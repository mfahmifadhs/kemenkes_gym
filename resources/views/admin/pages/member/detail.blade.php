@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-5">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Detail Member</small></h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('member') }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center p-2">
                        <i class="fas fa-circle-user fa-4x"></i>
                    </h3>
                </div>
                <div class="card-body">
                    <label class="text-secondary text-sm mb-0">
                        @if ($member->status == 'true') <i class="fas fa-check-circle fa-2x text-success"></i> @endif
                        @if ($member->status == 'false') <i class="fas fa-times-circle fa-2x text-danger"></i> @endif
                        <i>Informasi Member</i>
                    </label>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="mb-0 text-sm">ID</label>
                            <h6 class="text-sm">{{ $member->member_id }}</h6>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Nama</label>
                            <h6 class="text-sm">{{ $member->nama }}</h6>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">NIP/NIK</label>
                            <h6 class="text-sm">{{ $member->nip_nik }}</h6>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Asal Instansi</label>
                            <h6 class="text-sm text-capitalize mb-0">{{ $member->instansi }}</h6>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Nama Unit Kerja/UPT/Instansi</label>
                            <h6 class="text-sm text-capitalize mb-0">{{ $member->instansi != 'pusat' ? $member->nama_instansi : '' }}</h6>
                            @if($member->instansi == 'pusat')
                            <h6 class="text-sm text-capitalize mt-0">{{ $member->uker?->nama_unit_kerja }}</h6>
                            @endif
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Jenis Kelamin</label>
                            @if ($member->jenis_kelamin)
                            <h6 class="text-sm">{{ $member->jenis_kelamin == 'male' ? 'Laki-laki' : 'Perempuan' }}</h6>
                            @else <h6>-</h6> @endif
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Tempat/Tanggal Lahir</label>
                            @if ($member->tempat_lahir && $member->tanggal_lahir)
                            <h6 class="text-sm text-uppercase">{{ $member->tempat_lahir }}/{{ \Carbon\Carbon::parse($member->tanggal_lahir)->isoFormat('DD-MM-Y') }}</h6>
                            @else <h6>-</h6> @endif
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">No. Telepon</label>
                            <h6 class="text-sm">{{ $member->no_telp ?? '-' }}</h6>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Email</label>
                            <h6 class="text-sm">{{ $member->email }}</h6>
                        </div>
                    </div>
                    <hr>
                    <label class="text-secondary text-sm mb-0"><i>Informasi Kesehatan</i></label>
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <label class="mb-0 text-sm">Tinggi</label>
                            <h6 class="text-sm">{{ $member->tinggi }} cm</h6>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="mb-0 text-sm">Berat</label>
                            <h6 class="text-sm">{{ $member->berat }} kg</h6>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="mb-0 text-sm">BMI</label>
                            <h6 class="text-sm">
                                @php
                                if ($member->berat && $member->tinggi) {
                                    $bmi = number_format($member->berat / (($member->tinggi / 100) ** 2), 2);
                                } else { $bmi = 0; }
                                @endphp
                                {{ $bmi }}
                            </h6>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="mb-0 text-sm">Status</label>
                            <h6 class="text-sm">
                                @if ($bmi < 18.5) Kurang
                                @elseif ($bmi >= 18.5 && $bmi <= 24.9) Normal
                                @elseif ($bmi >= 25 && $bmi <= 29.9) Berat
                                @elseif ($bmi > 30) Obesitas @endif
                            </h6>
                        </div>
                    </div>
                    <hr>
                    <label class="text-secondary text-sm mb-0"><i>Informasi Target</i></label>
                    <div class="row">
                        @foreach ($member->minatTarget as $row)
                        <div class="col-md-4 mt-2">
                            <h6 class="text-sm">{{ $loop->iteration.'. '. ucwords(strtolower($row->target?->nama_target)) }}</h6>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <label class="text-secondary text-sm mb-0"><i>Peminatan Kelas</i></label>
                    <div class="row">
                        @foreach ($member->minatKelas as $row)
                        <div class="col-md-4 mt-2">
                            <h6 class="text-sm">{{ $loop->iteration.'. '.$row->kelas?->nama_kelas }}</h6>
                        </div>
                        @endforeach
                    </div>
                    @if (Auth::user()->role_id == 1)
                    <hr>
                    <label class="text-secondary text-sm mb-0"><i>Informasi Akun</i></label>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Username</label>
                            <h6 class="text-sm">{{ $member->username }}</h6>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0 text-sm">Password</label>
                            <h6 class="text-sm">{{ $member->password_teks }}</h6>
                        </div>
                    </div>
                    @endif
                </div>
                @if (Auth::user()->role_id == 1)
                <div class="card-footer text-right">
                    <a href="{{ route('member.email', $member->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-envelope"></i> Ubah Email
                    </a>
                    <a href="{{ route('member.password', $member->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-shield-halved"></i> Ubah Password
                    </a>
                    <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-pencil"></i> Ubah Informasi
                    </a>
                </div>
                @endif
            </div> <br>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {
        // Handle click event on clear button
        $(".clearSearch").on("click", function() {
            var form = $(this).closest('form');
            var inputField = form.find('input[type="search"]');
            console.log(inputField)
            inputField.val('');
            form.submit();
        });
    });
</script>

<!-- BMI -->
<script>
    function hitungBMI() {
        var tinggi = '{{ $member->tinggi }}';
        var berat = '{{ $member->berat }}';

        if (tinggi > 0 && berat > 0) {
            var bmi = berat / Math.pow(tinggi / 100, 2); // Menghitung BMI
            document.getElementById('bmi').value = bmi.toFixed(2); // Menampilkan BMI dengan 2 angka di belakang koma
        } else {
            document.getElementById('bmi').value = ''; // Mengosongkan nilai BMI jika tinggi atau berat tidak valid
        }
    }
</script>
@endsection
@endsection
