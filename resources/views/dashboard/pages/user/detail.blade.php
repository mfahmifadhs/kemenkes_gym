@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-7 mx-auto">
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>PROFILE</u></h4>
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
                @endif

                <div class="section-body mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center p-2">
                                <i class="fa fa-user fa-4x"></i>
                            </h3>
                        </div>
                        <div class="card-header text-center">
                            <a href="{{ route('member.email', $member->id) }}" class="btn btn-primary bg-main btn-sm">
                                <i class="fa fa-envelope"></i> Edit Email
                            </a>
                            <a href="{{ route('member.password', $member->id) }}" class="btn btn-primary bg-main btn-sm">
                                <i class="fa fa-shield"></i> Edit Password
                            </a>
                            <a href="{{ route('member.edit', $member->id) }}" class="btn btn-primary bg-main btn-sm">
                                <i class="fa fa-pencil"></i> Edit Profile
                            </a>
                        </div>
                        <div class="card-body">
                            <label class="text-secondary text-sm mb-0"><i>Informasi Member</i></label>
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">Nama</h6>
                                    <label class="text-sm">{{ $member->nama }}</label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">NIP/NIK</h6>
                                    <label class="text-sm">{{ $member->nip_nik }}</label>
                                </div>

                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">Asal Instansi</h6>
                                    <label class="text-sm text-capitalize mb-0">{{ $member->instansi }}</label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">Nama Unit Kerja/UPT/Instansi</h6>
                                    <label class="text-sm text-capitalize mb-0">{{ $member->instansi != 'pusat' ? $member->nama_instansi : '' }}</label>
                                    @if($member->instansi == 'pusat')
                                    <label class="text-sm text-capitalize mt-0">{{ $member->uker?->nama_unit_kerja }}</label>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">Jenis Kelamin</h6>
                                    <label class="text-sm">{{ $member->jenis_kelamin == 'male' ? 'Laki-laki' : 'Perempuan' }}</label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">Tempat/Tanggal Lahir</h6>
                                    <label class="text-sm text-uppercase">{{ $member->tempat_lahir }}/{{ \Carbon\Carbon::parse($member->tanggal_lahir)->isoFormat('DD-MM-Y') }}</label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">No. Telepon</h6>
                                    <label class="text-sm">{{ $member->no_telp ?? '-' }}</label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6 class="mb-0 text-sm">Email</h6>
                                    <label class="text-sm">{{ $member->email }}</label>
                                </div>
                            </div>
                            <hr>
                            <label class="text-secondary text-sm mb-0"><i>Informasi Kesehatan</i></label>
                            <div class="row">
                                <div class="col-md-3 col-3 mt-2">
                                    <h6 class="mb-0 text-sm">Tinggi</h6>
                                    <label class="text-sm">{{ $member->tinggi }} cm</label>
                                </div>
                                <div class="col-md-3 col-3 mt-2">
                                    <h6 class="mb-0 text-sm">Berat</h6>
                                    <label class="text-sm">{{ $member->berat }} kg</label>
                                </div>
                                <div class="col-md-3 col-3 mt-2">
                                    <h6 class="mb-0 text-sm">BMI</h6>
                                    <label class="text-sm">
                                        @php
                                        if ($member->berat && $member->tinggi) {
                                        $bmi = number_format($member->berat / (($member->tinggi / 100) ** 2), 2);
                                        } else { $bmi = 0; }
                                        @endphp
                                        {{ $bmi }}
                                    </label>
                                </div>
                                <div class="col-md-3 col-3 mt-2">
                                    <h6 class="mb-0 text-sm">Status</h6>
                                    <label class="text-sm">
                                        @if ($bmi < 18.5) Kurang @elseif ($bmi>= 18.5 && $bmi <= 24.9) Normal @elseif ($bmi>= 25 && $bmi <= 29.9) Berat @elseif ($bmi> 30) Obesitas @endif
                                                    </h6>
                                </div>
                            </div>
                            <hr>
                            <label class="text-secondary text-sm mb-0"><i>Informasi Target</i></label>
                            <div class="row">
                                @foreach ($member->minatTarget as $row)
                                <div class="col-md-4 mt-2">
                                    <label class="text-sm">{{ $loop->iteration.'. '. ucwords(strtolower($row->target?->nama_target)) }}</label>
                                </div>
                                @endforeach
                            </div>
                            <hr>
                            <label class="text-secondary text-sm mb-0"><i>Peminatan Kelas</i></label>
                            <div class="row">
                                @foreach ($member->minatKelas as $row)
                                <div class="col-md-4 col-6 mt-2">
                                    <label class="text-sm">{{ $loop->iteration.'. '.$row->kelas?->nama_kelas }}</label>
                                </div>
                                @endforeach
                            </div>
                            <hr>
                            <label class="text-secondary text-sm mb-0"><i>Informasi Akun</i></label>
                            <div class="row">
                                <div class="col-md-6 col-6 mt-2">
                                    <h6 class="mb-0 text-sm">Username</h6>
                                    <label class="text-sm">{{ $member->username }}</label>
                                </div>
                                <!-- <div class="col-md-6 col-6 mt-2">
                                    <h6 class="mb-0 text-sm">Password</h6>
                                    <label class="text-sm">{{ $member->password_teks }}</label>
                                </div> -->
                            </div>
                        </div>
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
            title: 'Join Class ?',
            text: 'if you join the class and you don`t come as long 3 times, you can`t join the class again',
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
