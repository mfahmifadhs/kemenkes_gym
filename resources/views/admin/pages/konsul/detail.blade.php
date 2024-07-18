@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-6">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Konsultasi</small></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('konsul') }}">Konsultasi</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('konsul') }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="p-2">
                                <!-- <img src="" class="text-primary w-50 img-circle"> -->
                                <div class="text-center">
                                    <i class="fa fa-user-circle fa-4x"></i>
                                </div>
                                <hr>

                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl {{ $konsul->test_sipgar == 1 ? 'badge-success' : 'badge-danger' }}"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title" style="padding-top: 10px;">Tes Vo2Max SIPGAR</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl {{ $konsul->test_fitness == 1 ? 'badge-success' : 'badge-danger' }}"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title" style="padding-top: 10px;">Tes Fitness</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl {{ $konsul->konsultasi == 1 ? 'badge-success' : 'badge-danger' }}"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title" style="padding-top: 10px;">
                                                    Konsul Dokter <br>
                                                    @if ($konsul->test_fitness)
                                                    <small>
                                                        <i class="fa fa-stethoscope"></i>
                                                        No. Antrian : {{ $konsul->kode_book }} <br>
                                                        <i class="fa fa-calendar-alt"></i>
                                                        {{ Carbon\Carbon::parse($konsul->tanggal_konsul)->isoFormat('DD MMMM Y') }} <br>
                                                        <i class="fa fa-clock"></i>
                                                        @if ($konsul->waktu_konsul == 1) 07.00 WIB s/d 07.30 WIB @endif
                                                        @if ($konsul->waktu_konsul == 2) 07.30 WIB s/d 08.00 WIB @endif
                                                        @if ($konsul->waktu_konsul == 3) 08.00 WIB s/d 08.30 WIB @endif
                                                        @if ($konsul->waktu_konsul == 4) 08.30 WIB s/d 09.00 WIB @endif
                                                        <br>
                                                        <i class="fa fa-map-pin"></i> Ruang Dokter, Kemenkes Bootcamp & Fitness Center
                                                    </small>
                                                    @endif
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </h3>
                        </div>
                        <div class="col-md-8">
                            <label class="text-secondary text-sm mb-0">
                                <i>Profil Pasien</i>
                            </label>
                            <div class="row">
                                <div class="col-md-6 col-5">
                                    <label class="mb-0 text-sm">Kode Book</label>
                                    <h6 class="text-sm">{{ $konsul->kode_book }}</h6>
                                </div>
                                <div class="col-md-6 col-7">
                                    <label class="mb-0 text-sm">Member ID</label>
                                    <h6 class="text-sm">{{ $konsul->member->member_id }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Nama Pasien</label>
                                    <h6 class="text-sm">{{ $konsul->member->nama }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Jenis Kelamin</label>
                                    <h6 class="text-sm">{{ $konsul->member->jenis_kelamin == 'male' ? 'Laki-laki' : 'Perempuan' }}</h6>
                                </div>
                                <div class="col-md-6 col-6">
                                    <label class="mb-0 text-sm">Tanggal Lahir</label>
                                    <h6 class="text-sm">{{ Carbon\Carbon::parse($konsul->member->tanggal_lahir)->isoFormat('DD MMMM Y') }}</h6>
                                </div>
                                <div class="col-md-6 col-6">
                                    <label class="mb-0 text-sm">Usia</label>
                                    <h6 class="text-sm">{{ Carbon\Carbon::parse($konsul->member->tanggal_lahir)->age; }} tahun</h6>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0 text-sm">Asal</label>
                                    <h6 class="text-sm">{{ $konsul->member->instansi == 'pusat' ? $konsul->member->uker->nama_unit_kerja : $konsul->member->nama_instansi }}</h6>
                                </div>
                            </div>
                            <hr>
                            <label class="text-secondary text-sm mb-0">
                                <i>Progres</i>
                            </label>

                            <form id="form" action="{{ route('konsul.update', $id) }}" method="GET">
                                <div class="row">
                                    <label class="col-md-4 col-6">1. Test Sipgar</label>
                                    <label class="col-md-1 col-1">:</label>
                                    <div class="col-md-7 col-12">
                                        <!-- Test Sipgar -->
                                        <input id="true-sipgar" type="radio" name="sipgar" class="ml-2" value="1" {{ $konsul->test_sipgar == true ? 'checked' : '' }}>
                                        <label for="true-sipgar"><i class="fa fa-check-circle text-xs text-success"></i> sudah</label>

                                        <input id="false-sipgar" type="radio" name="sipgar" class="ml-2" value="0" {{ $konsul->test_sipgar == false ? 'checked' : '' }}>
                                        <label for="false-sipgar"><i class="fa fa-times-circle text-xs text-danger"></i> belum</label>
                                    </div>


                                    <label class="col-md-4 col-6">2. Test Fitness</label>
                                    <label class="col-md-1 col-1">:</label>
                                    <div class="col-md-7 col-12">
                                        <!-- Test Fitness -->
                                        <input id="true-fitness" type="radio" name="fitness" class="ml-2" value="1" {{ $konsul->test_fitness == true ? 'checked' : '' }}>
                                        <label for="true-fitness"><i class="fa fa-check-circle text-xs text-success"></i> sudah</label>

                                        <input id="false-fitness" type="radio" name="fitness" class="ml-2" value="0" {{ $konsul->test_fitness == false ? 'checked' : '' }}>
                                        <label for="false-fitness"><i class="fa fa-times-circle text-xs text-danger"></i> belum</label>
                                    </div>

                                    @if ($konsul->test_sipgar == 1 && $konsul->test_fitness == 1)
                                    <label class="col-md-4 col-6 mt-1">3. Tanggal Konsul</label>
                                    <label class="col-md-1 col-1">:</label>
                                    <div class="col-md-7 col-12">
                                        <div class="input-group">
                                            <input id="tanggal_konsul" type="date" class="form-control form-control-sm ml-2" name="tanggal_konsul" value="{{ $konsul->tanggal_konsul }}" min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>

                                    <label class="col-md-4 col-6 mt-2">3. Waktu Konsul</label>
                                    <label class="col-md-1 col-1 mt-2">:</label>
                                    <div class="col-md-7 col-12">
                                        <div class="input-group">
                                            <select name="waktu_konsul" class="form-control form-control-sm ml-2" id="">
                                                <option value="">-- Pilih Waktu --</option>
                                                <option value="1" <?php echo $konsul->waktu_konsul == 1 ? 'selected' : ''; ?>>07.00 s/d 07.30</option>
                                                <option value="2" <?php echo $konsul->waktu_konsul == 2 ? 'selected' : ''; ?>>07.30 s/d 08.00</option>
                                                <option value="3" <?php echo $konsul->waktu_konsul == 3 ? 'selected' : ''; ?>>08.00 s/d 08.30</option>
                                                <option value="4" <?php echo $konsul->waktu_konsul == 4 ? 'selected' : ''; ?>>08.30 s/d 09.00</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($konsul->test_sipgar == 1 && $konsul->test_fitness == 1 && $konsul->tanggal_konsul)
                                    <div class="col-md-12 col-12 text-sm mt-3">
                                        <hr>
                                        <h6>Konsultasi:</h6>
                                        <label for="catatan_dokter">
                                            Catatan Dokter <br>
                                            <span class="text-danger" style="font-size: 10px;">
                                                Catatan bersifat rahasia, dan tidak akan diberitahukan kepada pasien
                                            </span>
                                        </label>
                                        <textarea name="catatan_dokter" class="form-control" id="catatan_dokter" rows="10">{{ $konsul->catatan_dokter }}</textarea>
                                    </div>
                                    <div class="col-md-12 col-12 text-sm mt-3">
                                        <label for="catatan_pasien">Catatan Pasien</label>
                                        <textarea name="catatan_pasien" class="form-control" id="catatan_pasien" rows="10">{{ $konsul->catatan_pasien }}</textarea>
                                    </div>
                                    @endif

                                    <div class="col-md-4 col-4 mt-2">&nbsp;</div>
                                    <div class="col-md-8 col-8 mt-5 text-right">
                                        <button type="submit" class="btn btn-primary btn-sm btn-info" onclick="confirmSubmit(event)">
                                            <i class="fa fa-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>


@section('js')
<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: "Loading...",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            willOpen: () => {
                Swal.showLoading();
            },
        })

        form.submit();

    }
</script>
@endsection
@endsection
