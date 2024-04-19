@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto mt-5">
                <div class="section-title contact-title text-center">
                    <h2><u>Form Registration Member</u></h2>
                </div>
                <div class="leave-comment">
                    @if ($message = Session::get('failed'))
                    <div id="alert" class="alert bg-danger">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                    @endif
                    <form id="form-daftar" action="{{ route('daftar') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="text-white small">Nama lengkap*</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-white small">NIP/NIK*</label>
                                <input type="text" class="form-control number" name="nipnik" placeholder="NIP/NIK" maxlength="20" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-white small">Jenis kelamin*</label>
                                <select name="jkelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="text-white small">Templat lahir*</label>
                                <input type="text" class="form-control" name="tempat_lahir" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-white small">Tanggal lahir*</label>
                                <input type="date" class="form-control" name="tanggal_lahir" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-white small">Institusi*</label>
                                <select name="instansi" required>
                                    <option value="">-- Pilih Institusi --</option>
                                    <option value="pusat">Kemenkes Pusat</option>
                                    <option value="upt">UPT</option>
                                    <option value="umum">Umum</option>
                                </select>
                            </div>
                        </div>

                        <div id="pusat" class="d-none">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-white small">Unit Utama*</label>
                                    <select id="utamaSelect" name="utama">
                                        <option value="">-- Select Unit Utama --</option>
                                        @foreach ($utama as $row)
                                        <option value="{{ $row->id_unit_utama }}">
                                            {{ $row->nama_unit_utama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-white small">Unit Kerja*</label>
                                    <select id="ukerSelect" name="uker">
                                        <option value="">-- Select Unit Kerja --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="umum" class="d-none">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-white small">Nama UPT/Institusi*</label>
                                    <input type="text" class="form-control" name="nama_instansi">
                                </div>
                            </div>
                        </div>

                        <hr class="bg-white">

                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label class="text-white small">Gym program* <i class="small">(Max. 3 pilihan)</i> </label>
                                <select id="peminatan" name="peminatan[]" multiple required>
                                    <option value="">-- Pilih Peminatan Kelas --</option>
                                    @foreach ($kelas as $row)
                                    <option value="{{ $row->id_kelas }}">{{ $row->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="text-white small">Target*</label>
                                <select id="target" name="target[]" multiple required>
                                    <option value="">-- Pilih Target --</option>
                                    @foreach ($target as $row)
                                    <option value="{{ $row->id_target }}">{{ $row->nama_target }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="bg-white">

                        <div class="row">
                            <div class="col-md-4">
                                <label class="text-white small">Tinggi* (cm)</label>
                                <input type="number" class="form-control" id="tinggi" name="tinggi" required>
                            </div>
                            <div class="col-md-4">
                                <label class="text-white small">Berat* (kg)</label>
                                <input type="number" class="form-control" id="berat" name="berat" required>
                            </div>
                            <div class="col-md-4">
                                <label class="text-white small">BMI</label>
                                <input type="number" id="bmi" readonly>
                            </div>
                        </div>

                        <hr class="bg-white">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="text-white small">Email*</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-white small">Username*</label>
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>

                            <div class="col-md-6">
                                <label class="text-white small mt-4">Password*</label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-dark" id="password" name="password" required>
                                    <div class="input-group-append border border-dark">
                                        <span class="input-group-text h-100 rounded-0 bg-white">
                                            <i class="fa fa-eye" id="eye-icon-pass"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-white small mt-4">Konfirmasi Password*</label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-dark" id="conf-password" required>
                                    <div class="input-group-append border border-dark">
                                        <span class="input-group-text h-100 rounded-0 bg-white">
                                            <i class="fa fa-eye" id="eye-conf-pass"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="mt-4" onclick="confirmSubmit(event)">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

@section('js')
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
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form-daftar');

        var password = $("#password").val();
        var confPass = $("#conf-password").val();
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
            if (password != confPass && password != null) {
                Swal.fire({
                    title: 'Konfirmasi password tidak sama!',
                    icon: 'error'
                });
                return false;
            } else {
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
            }
        } else {
            Swal.fire({
                title: 'Gagal',
                text: 'Seluruh Kolom Harus Diisi',
                icon: 'error',
            });
        }

    }

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
<!-- BMI -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Menangani perubahan pada input tinggi dan berat
        document.getElementById('tinggi').addEventListener('input', hitungBMI);
        document.getElementById('berat').addEventListener('input', hitungBMI);
    });

    function hitungBMI() {
        var tinggi = parseFloat(document.getElementById('tinggi').value);
        var berat = parseFloat(document.getElementById('berat').value);

        if (tinggi > 0 && berat > 0) {
            var bmi = berat / Math.pow(tinggi / 100, 2); // Menghitung BMI
            document.getElementById('bmi').value = bmi.toFixed(2); // Menampilkan BMI dengan 2 angka di belakang koma
        } else {
            document.getElementById('bmi').value = ''; // Mengosongkan nilai BMI jika tinggi atau berat tidak valid
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#peminatan').change(function() {
            var selectedOptions = $('#peminatan').val();
            var jumlahDipilih = selectedOptions.length;

            if (jumlahDipilih >= 3) {
                $('#peminatan option:not(:selected)').prop('disabled', true);
            } else {
                $('#peminatan option').prop('disabled', false);
            }
        });

        $('#target').change(function() {
            var selectedOptions = $('#target').val();
            var jumlahDipilih = selectedOptions.length;

            if (jumlahDipilih >= 3) {
                $('#target option:not(:selected)').prop('disabled', true);
            } else {
                $('#target option').prop('disabled', false);
            }
        });
    });
</script>
@endsection
@endsection
