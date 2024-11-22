@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-6">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-lg">Create Schedule</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ucwords(strtolower($kelas->nama_kelas)) }}</a></li>
                        <li class="breadcrumb-item active">Create Schedule</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-6">
            <div class="card">
                <form id="form-jadwal" action="{{ route('jadwal.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id_kelas }}">
                    <div class="card-body">
                        <div class="row text-sm">
                            <div class="col-md-6">
                                <label class="mb-1">Date*</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ $date }}" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1">Kuota*</label>
                                <input type="text" class="form-control number" name="kuota" required>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 mt-3">Start Time*</label>
                                <input type="time" class="form-control" name="waktu_mulai" required>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 mt-3">Finish Time*</label>
                                <input type="time" class="form-control" name="waktu_selesai" required>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 mt-3">Personal Trainer Name</label>
                                <input type="text" class="form-control" name="nama_pelatih">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 mt-3">Location</label>
                                <input type="text" class="form-control" name="lokasi" value="Kemenkes Bootcamp & Fitness Center">
                                @if (Auth::user()->uker->unit_utama_id)
                                <input type="hidden" name="lokasi_id" value="2">
                                @endif
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-block" onclick="confirmSubmit(event)">
                                    <b>CREATE</b>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><br>
        </div>
    </div>
</div>

@section('js')
<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form   = document.getElementById('form-jadwal');
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
                title: 'Failed',
                text: 'Please fill out this field.',
                icon: 'error',
            });
        }

    }
</script>
@endsection
@endsection
