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
            <div class="card border border-dark">
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
                                                        No. Antrian : {{ $konsul->antrian_konsul }} <br>
                                                        <i class="fa fa-calendar-alt"></i>
                                                        {{ Carbon\Carbon::parse($konsul->tanggal_konsul)->isoFormat('DD MMMM Y') }} <br>
                                                        <i class="fa fa-clock"></i>
                                                        @if ($konsul->waktu_konsul == 1) 07.00 WIB s/d 07.20 WIB @endif
                                                        @if ($konsul->waktu_konsul == 2) 07.20 WIB s/d 07.40 WIB @endif
                                                        @if ($konsul->waktu_konsul == 3) 07.40 WIB s/d 08.00 WIB @endif
                                                        @if ($konsul->waktu_konsul == 4) 08.00 WIB s/d 08.20 WIB @endif
                                                        @if ($konsul->waktu_konsul == 5) 08.20 WIB s/d 08.40 WIB @endif
                                                        @if ($konsul->waktu_konsul == 6) 08.40 WIB s/d 09.00 WIB @endif
                                                        <br>
                                                        <i class="fa fa-map-pin"></i> Ruang Dokter, Kemenkes Bootcamp & Fitness Center
                                                    </small>
                                                    @endif
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <label class="text-secondary text-sm mb-3">
                                    <i>Komposisi Tubuh</i>
                                </label>
                                <div class="row">
                                    <h6 class="col-md-12 col-12 text-sm">
                                        {{ $konsul->member->bodycp->last()->tanggal_cek }}
                                    </h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; Berat Badan</h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->weight }} kg</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; Tinggi Badan</h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->height }} cm</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; <i>Fat Percent</i></h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->fatp }} %</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; <i>Fat</i></h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->fatm }} kg</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; <i>Muscle Mass</i></h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->pmm }} kg</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; <i>Bone Mass</i></h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->bonem }} kg</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; <i>Visceral Fat</i></h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->vfatl }}</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; <i>Metablic Age</i></h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->metaage }} tahun</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; BMI</h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->bmi }} kg</h6>

                                    <h6 class="col-md-7 col-3 text-sm">&bull; BMR</h6>
                                    <h6 class="col-md-5 col-3 text-sm">: {{ $konsul->member->bodycp->last()->bmr }} kg</h6>
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

                            <form id="form" action="{{ route('konsul.update', $id) }}" method="GET">
                                <div class="row">
                                    @if ($konsul->test_sipgar == 1 && $konsul->test_fitness == 1 && $konsul->tanggal_konsul)
                                    <div class="col-md-12 col-12 form-group text-sm mt-3">
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
                                    <div class="col-md-12 col-12 form-group text-sm mt-3">
                                        <label for="catatan_pasien">Catatan Pasien</label>
                                        <textarea name="catatan_pasien" class="form-control" id="catatan_pasien" rows="10">{{ $konsul->catatan_pasien }}</textarea>
                                    </div>
                                    @endif

                                    @if ($konsul->test_sipgar == 1 && $konsul->test_fitness == 1)
                                    <label class="col-md-4 col-6 mt-1">3. Tanggal Konsul</label>
                                    <label class="col-md-1 col-1">:</label>
                                    <div class="col-md-7 col-12 form-group">
                                        <div class="input-group">
                                            <input id="tanggal_konsul" type="date" class="form-control form-control-sm" name="tanggal_konsul" value="{{ $konsul->tanggal_konsul }}" min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>

                                    <label class="col-md-4 col-6 mt-2">4. Waktu Konsul</label>
                                    <label class="col-md-1 col-1 mt-2">:</label>
                                    <div class="col-md-7 col-12 form-group">
                                        <div class="input-group">
                                            <select name="waktu_konsul" class="form-control form-control-sm" id="">
                                                <option value="">-- Pilih Waktu --</option>
                                                <option value="1" <?php echo $konsul->waktu_konsul == 1 ? 'selected' : ''; ?>>07.00 s/d 07.20</option>
                                                <option value="2" <?php echo $konsul->waktu_konsul == 2 ? 'selected' : ''; ?>>07.20 s/d 07.40</option>
                                                <option value="3" <?php echo $konsul->waktu_konsul == 3 ? 'selected' : ''; ?>>07.40 s/d 08.00</option>
                                                <option value="4" <?php echo $konsul->waktu_konsul == 4 ? 'selected' : ''; ?>>08.00 s/d 08.20</option>
                                                <option value="4" <?php echo $konsul->waktu_konsul == 5 ? 'selected' : ''; ?>>08.20 s/d 08.40</option>
                                                <option value="4" <?php echo $konsul->waktu_konsul == 6 ? 'selected' : ''; ?>>08.40 s/d 09.00</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="col-md-4 col-6 mt-2">5. No. Antrian</label>
                                    <label class="col-md-1 col-1 mt-2">:</label>
                                    <div class="col-md-7 col-12 form-group mt-1">
                                        <div class="input-group mb-3">
                                            <input id="nomor_antrian" type="text" name="antrian_konsul" class="form-control form-control-sm" value="{{ $konsul?->antrian_konsul }}">
                                            <div class="input-group-append">
                                                <button id="ambil_nomor" type="button" class="input-group-text bg-white border-dark text-xs">Ambil Nomor</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    @endif

                                    @if ($konsul->test_sipgar == 1)
                                    <label class="col-md-4 col-6">2. Test Fitness</label>
                                    <label class="col-md-1 col-1">:</label>
                                    <div class="col-md-7 col-12 form-group">
                                        <small class="text-xs"><b>a. <i>Back and stretch</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_backs" placeholder="Hasil (cm)" value="{{ $konsul->hasil_backs }}">
                                            <select class="form-control form-control-sm w-25" name="kategori_backs">
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="baik" <?php echo $konsul->kategori_backs == 'baik' ? 'selected' : ''; ?>>Baik</option>
                                                <option value="cukup" <?php echo $konsul->kategori_backs == 'cukup' ? 'selected' : ''; ?>>Cukup</option>
                                                <option value="kurang" <?php echo $konsul->kategori_backs == 'kurang' ? 'selected' : ''; ?>>Kurang</option>
                                            </select>
                                        </div>

                                        <small class="text-xs"><b>b. <i>Handgrip Dynamometer Kiri</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_dynamo_l" placeholder="Kiri (kg)" value="{{ $konsul->hasil_dynamo_l }}">
                                            <select class="form-control form-control-sm w-25" name="kategori_dynamo_l">
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="baik" <?php echo $konsul->kategori_dynamo_l == 'baik' ? 'selected' : ''; ?>>Baik</option>
                                                <option value="cukup" <?php echo $konsul->kategori_dynamo_l == 'cukup' ? 'selected' : ''; ?>>Cukup</option>
                                                <option value="kurang" <?php echo $konsul->kategori_dynamo_l == 'kurang' ? 'selected' : ''; ?>>Kurang</option>
                                            </select>
                                        </div>

                                        <small class="text-xs"><b>b. <i>Handgrip Dynamometer Kanan</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_dynamo_r" placeholder="Kanan (kg)" value="{{ $konsul->hasil_dynamo_r }}">
                                            <select class="form-control form-control-sm w-25" name="kategori_dynamo_r">
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="baik" <?php echo $konsul->kategori_dynamo_r == 'baik' ? 'selected' : ''; ?>>Baik</option>
                                                <option value="cukup" <?php echo $konsul->kategori_dynamo_r == 'cukup' ? 'selected' : ''; ?>>Cukup</option>
                                                <option value="kurang" <?php echo $konsul->kategori_dynamo_r == 'kurang' ? 'selected' : ''; ?>>Kurang</option>
                                            </select>
                                        </div>

                                        <small class="text-xs"><b>c. <i>Plank</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_plank" placeholder="Waktu" value="{{ $konsul->hasil_plank }}">
                                        </div>

                                        <small class="text-xs"><b>d. <i>Sit Up</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_situp" placeholder="Total" value="{{ $konsul->hasil_situp }}">
                                            <select class="form-control form-control-sm w-25" name="kategori_situp">
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="baik" <?php echo $konsul->kategori_situp == 'baik' ? 'selected' : ''; ?>>Baik</option>
                                                <option value="cukup" <?php echo $konsul->kategori_situp == 'cukup' ? 'selected' : ''; ?>>Cukup</option>
                                                <option value="kurang" <?php echo $konsul->kategori_situp == 'kurang' ? 'selected' : ''; ?>>Kurang</option>
                                            </select>
                                        </div>

                                        <small class="text-xs"><b>e. <i>Lingkar perut</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_lingperut" placeholder="Hasil (cm)" value="{{ $konsul->hasil_lingperut }}">
                                        </div>

                                        <small class="text-xs"><b>f. <i>Tekanan darah</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="text" class="form-control form-control-sm number" min="0" name="hasil_tekdarah" placeholder="Hasil (mmHg)" value="{{ $konsul->hasil_tekdarah }}">
                                        </div>

                                        <small class="text-xs"><b>g. <i>Denyut nadi</i></b></small>
                                        <div class="input-group mt-0">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_nadi" placeholder="Hasil (kali/menit)" value="{{ $konsul->hasil_nadi }}">
                                        </div>


                                        <!-- Test Fitness -->
                                        <!-- <input id="true-fitness" type="radio" name="fitness" class="ml-2" value="1" {{ $konsul->test_fitness == true ? 'checked' : '' }}>
                                        <label for="true-fitness"><i class="fa fa-check-circle text-xs text-success"></i> sudah</label>

                                        <input id="false-fitness" type="radio" name="fitness" class="ml-2" value="0" {{ $konsul->test_fitness == false ? 'checked' : '' }}>
                                        <label for="false-fitness"><i class="fa fa-times-circle text-xs text-danger"></i> belum</label> -->
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    @endif


                                    <label class="col-md-4 col-6">1. Test Sipgar</label>
                                    <label class="col-md-1 col-1">:</label>
                                    <div class="col-md-7 col-12 form-group">
                                        <div class="input-group">
                                            <input type="number" class="form-control form-control-sm" min="0" name="hasil_sipgar" placeholder="Waktu" value="{{ $konsul->hasil_sipgar }}">
                                            <select class="form-control form-control-sm w-25" name="kategori_sipgar">
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="sangatbaik" <?php echo $konsul->kategori_sipgar == 'sangatbaik' ? 'selected' : ''; ?>>Sangat Baik</option>
                                                <option value="baik" <?php echo $konsul->kategori_sipgar == 'baik' ? 'selected' : ''; ?>>Baik</option>
                                                <option value="cukup" <?php echo $konsul->kategori_sipgar == 'cukup' ? 'selected' : ''; ?>>Cukup</option>
                                                <option value="kurang" <?php echo $konsul->kategori_sipgar == 'kurang' ? 'selected' : ''; ?>>Kurang</option>
                                                <option value="sangatkurang" <?php echo $konsul->kategori_sipgar == 'sangatkurang' ? 'selected' : ''; ?>>Sangat Kurang</option>
                                            </select>
                                        </div>
                                    </div>




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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('ambil_nomor').addEventListener('click', function() {
            var tanggal = document.getElementById('tanggal_konsul').value;

            if (tanggal) {
                fetch(`/antrian-konsul?tanggal=${tanggal}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('nomor_antrian').value = data.nomor_antrian;
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Silakan pilih tanggal terlebih dahulu.');
            }
        });
    });
</script>
@endsection
@endsection
