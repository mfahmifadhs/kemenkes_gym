@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>PROFILE</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('profile', $member->id) }}" class="btn btn-primary">
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

                <div class="section-body mb-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-secondary text-sm mb-0">
                                        <i>Informasi Kelas</i> <br> <small>(auto simpan)</small>
                                    </label>
                                    @for ($i = 0; $i < 3; $i++) <form id="formKelas{{ $i }}" action="{{ route('member.update', $member->id) }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3 mt-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text border-dark">{{ $i+1 }}</span>
                                            </div>
                                            <input type="hidden" name="kelas" value="true">
                                            <input type="hidden" name="kelas_update_id" value="{{ isset($member->minatKelas[$i]) ? $member->minatKelas[$i]->id_minat_kelas : '' }}">
                                            <select name="kelas_update" class="form-control border-dark" onchange="submitKelas(<?php echo $i; ?>)">
                                                <option value="">TIDAK MEMILIH KELAS</option>
                                                @foreach ($kelas as $row)
                                                <option value="{{ $row->id_kelas }}" {{ isset($member->minatKelas[$i]) && $member->minatKelas[$i]->kelas_id == $row->id_kelas ? 'selected' : '' }}>
                                                    {{ $row->nama_kelas }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </form>
                                        @endfor
                                </div>
                                <div class="col-md-6">
                                    <label class="text-secondary text-sm mb-0">
                                        <i>Informasi Target</i> <br> <small>(auto simpan)</small>
                                    </label>
                                    @for ($i = 0; $i < 3; $i++) <form id="formTarget{{ $i }}" action="{{ route('member.update', $member->id) }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3 mt-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text border-dark">{{ $i+1 }}</span>
                                            </div>
                                            <input type="hidden" name="target" value="true">
                                            <input type="hidden" name="target_update_id" value="{{ isset($member->minatTarget[$i]) ? $member->minatTarget[$i]->id_minat_target : '' }}">
                                            <select name="target_update" class="form-control border-dark" onchange="submitTarget(<?php echo $i; ?>)">
                                                <option value="">TIDAK MEMILIH TARGET</option>
                                                @foreach ($target as $row)
                                                <option value="{{ $row->id_target }}" {{ isset($member->minatTarget[$i]) && $member->minatTarget[$i]->target_id == $row->id_target ? 'selected' : '' }}>
                                                    {{ $row->nama_target }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </form>
                                        @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <form id="form" action="{{ route('member.update', $member->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <label class="text-secondary text-sm mb-0"><i>Informasi Member</i></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">Nama</label>
                                        <input type="text" class="form-control border-dark" name="nama" value="{{ $member->nama }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">NIP/NIK</label>
                                        <input type="number" class="form-control number border-dark" name="nipnik" value="{{ $member->nip_nik }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">Jenis Kelamin</label>
                                        <select name="jkelamin" class="form-control border-dark" required>
                                            <option value="male" <?php echo $member->jenis_kelamin == 'male' ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="female" <?php echo $member->jenis_kelamin == 'female' ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">Tempat Lahir</label>
                                        <input type="text" class="form-control border-dark" name="tempat_lahir" value="{{ $member->tempat_lahir }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">Tanggal Lahir</label>
                                        <input type="date" class="form-control border-dark" name="tanggal_lahir" value="{{ $member->tanggal_lahir }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">No. Telepon</label>
                                        <input type="text" class="form-control number border-dark" name="no_telp" value="{{ $member->no_telp }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">Asal Instansi</label>
                                        <select name="instansi" class="form-control border-dark" required>
                                            <option value="pusat" <?php echo $member->instansi == 'pusat' ? 'selected' : '' ?>>PUSAT</option>
                                            <option value="umum" <?php echo $member->instansi == 'umum' ? 'selected' : '' ?>>UMUM</option>
                                            <option value="upt" <?php echo $member->instansi == 'upt' ? 'selected' : '' ?>>UPT</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <div id="umum" class="{{ $member->instansi ==  'pusat' ? 'd-none' : '' }}">
                                            <label class="col-form-label text-sm">Nama Instansi</label>
                                            <input type="text" class="form-control border-dark" name="nama_instansi" value="{{ $member->nama_instansi }}">
                                        </div>
                                    </div>
                                </div>

                                <div id="pusat" class="{{ $member->instansi != 'pusat' ? 'd-none' : '' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label text-sm">Unit Utama</label>
                                            <select id="utamaSelect" class="form-control border-dark" name="utama">
                                                <option value="">-- Pilih Unit Utama --</option>
                                                @foreach ($utama as $row)
                                                <option value="{{ $row->id_unit_utama }}" <?php echo $member->uker?->unit_utama_id == $row->id_unit_utama ? 'selected' : ''; ?>>
                                                    {{ $row->nama_unit_utama }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-form-label text-sm">Unit Kerja</label>
                                            <select id="ukerSelect" class="form-control border-dark" name="uker">
                                                <option value="">-- Pilih Unit Kerja --</option>
                                                @foreach ($uker as $row)
                                                <option value="{{ $row->id_unit_kerja }}" <?php echo $member->uker_id == $row->id_unit_kerja ? 'selected' : ''; ?>>
                                                    {{ $row->nama_unit_kerja }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">Tinggi Badan</label>
                                        <input type="text" class="form-control border-dark" name="tinggi" value="{{ $member->tinggi }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label text-sm">Berat Badan</label>
                                        <input type="text" class="form-control border-dark" name="berat" value="{{ $member->berat }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" onclick="confirmSubmit(event)">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@section('js')
<script>
    function submitKelas(formIndex) {
        document.getElementById('formKelas' + formIndex).submit()
    }

    function submitTarget(formIndex) {
        document.getElementById('formTarget' + formIndex).submit()
    }
</script>

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

<script>
    $(document).ready(function() {
        $('select[name="peminatan[]"]').select2()
        $('select[name="target[]"]').select2()
        // Asal Instansi
        $('select[name="instansi"]').change(function() {
            var selectedValue = $(this).val()

            if (selectedValue === 'pusat') {
                $('#pusat').removeClass('d-none')
                $('#umum').addClass('d-none')
            } else if (selectedValue === 'umum') {
                $('#pusat').addClass('d-none')
                $('#umum').removeClass('d-none')
            } else if (selectedValue === 'upt') {
                $('#pusat').addClass('d-none')
                $('#umum').removeClass('d-none')
            } else {
                $('#pusat').addClass('d-none')
                $('#umum').addClass('d-none')
            }
        });
    })
</script>

<script>
    $('#utamaSelect').change(function() {
        var selectedUtamaId = $(this).val();

        $.ajax({
            url: '/uker/select/' + selectedUtamaId,
            type: 'GET',
            success: function(data) {
                $('#ukerSelect').empty();
                $.each(data, function(key, val) {
                    $('#ukerSelect').append('<option value="' + val.id + '">' + val.text + '</option>');
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>

<script>
    function toggleRequired() {
        var instansi = document.getElementById('instansi').value;
        var idUker = document.getElementById('ukerSelect');
        var idUmum = document.getElementById('namaInstansi');

        if (instansi === 'pusat') {
            idUker.setAttribute('required', 'required');
        } else {
            idUker.removeAttribute('required');
        }

        if (instansi === 'umum' || instansi === 'upt') {
            idUmum.setAttribute('required', 'required');
        } else {
            idUmum.removeAttribute('required');
        }
    }
</script>

<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        const inputs = form.querySelectorAll('select[required], input[required], textarea[required]');
        let isFormValid = true;

        inputs.forEach(input => {
            if (input.hasAttribute('required') && input.value.trim() === '') {
                input.style.borderColor = 'red';
                isFormValid = false;
            } else {
                input.style.borderColor = '';
            }
        });

        if (isFormValid) {
            Swal.fire({
                title: "Proses...",
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            })

            form.submit();
        } else {
            Swal.fire({
                title: 'Gagal',
                text: 'Seluruh Kolom Harus Diisi',
                icon: 'error',
            });
        }

    }
</script>

@endsection
@endsection
