@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row" style="margin-bottom: -5vh;">
                    <div class="col-8 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>BODY COMPOSITION</u></h4>
                        </div>
                    </div>
                    <div class="col-4 text-right mt-1">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="section-body">
                    <div class="section-title mb-2"><span>Create Progress</span></div>
                    <div class="schedule">
                        <form id="form" action="{{ route('bodyck.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12 col-12">
                                    <label class="text-white small">Date*</label>
                                    <input type="datetime-local" class="form-control" name="tanggal" value="{{ Carbon\Carbon::now()->isoFormat('Y-MM-DD HH:mm') }}">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Body Type*</label>
                                    <select name="tipe_badan" class="form-control" required>
                                        <option value="std">Standard</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Serial Number*</label>
                                    <input type="number" class="form-control" name="no_serial" placeholder="only input last lumber, ex: 00001 -> 1">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Height*</label>
                                    <input id="tinggi" type="number" class="form-control" name="bodyck_tinggi" value="{{ Auth::user()->tinggi }}">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Clothes Weight (kg)*</label>
                                    <input type="number" class="form-control" name="berat_baju">
                                </div>
                                <div class="form-group col-md-12 col-12 mb-0">
                                    <label class="section-title mb-2 text-white"><small>Result</small></label>
                                </div>
                                <div class="form-group col-md-12 col-12 mb-0">
                                    <div class="row">
                                        @foreach ($param as $i => $row)
                                        <div class="col-md-4 mb-2 col-form-label text-white">{{ $loop->iteration.'. '.$row->nama_param .' '. $row->satuan }}*</div>
                                        <div class="col-md-8 mb-2">
                                            <input type="hidden" name="key[]" value="{{ $row->id_param }}" required>
                                            <input type="number" class="form-control" id="val_{{ $row->id_param }}" name="val_{{ $row->id_param }}" required>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block mt-3" onclick="confirmSubmit(event)">Create</button>
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
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');
        const inputs = form.querySelectorAll('select[required], input[required]');
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
                title: "Process...",
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
                title: 'Fail',
                text: 'Please complete all columns',
                icon: 'error',
            });
        }

    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Menangani perubahan pada input tinggi dan berat
        document.getElementById('tinggi').addEventListener('input', hitungBMI);
        document.getElementById('val_1').addEventListener('input', hitungBMI);
        document.getElementById('val_12').setAttribute('readonly', 'readonly');
    });

    function hitungBMI() {
        var tinggi = parseFloat(document.getElementById('tinggi').value);
        var berat = parseFloat(document.getElementById('val_1').value);
        console.log(tinggi)
        if (tinggi > 0 && berat > 0) {
            var bmi = berat / Math.pow(tinggi / 100, 2); // Menghitung BMI
            document.getElementById('val_12').value = bmi.toFixed(1);
        } else {
            document.getElementById('val_12').value = '';
        }
    }
</script>
@endsection

@endsection
