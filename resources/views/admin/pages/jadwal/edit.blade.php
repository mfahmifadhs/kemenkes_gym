@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-6">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-lg">Edit Schedule</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ucwords(strtolower($jadwal->kelas->nama_kelas)) }}</a></li>
                        <li class="breadcrumb-item active">Edit Schedule</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-6">
            <div class="card">
                <form id="form-jadwal" action="{{ route('jadwal.update', $jadwal->id_jadwal) }}" method="POST">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $jadwal->kelas_id }}">
                    <div class="card-body">
                        <div class="row text-sm">
                            <div class="col-md-6">
                                <label class="mb-1">Date*</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ $jadwal->tanggal_kelas }}" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1">Kuota*</label>
                                <input type="text" class="form-control number" name="kuota" value="{{ $jadwal->kuota }}">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 mt-3">Start Time*</label>
                                <input type="time" class="form-control" name="waktu_mulai" value="{{ $jadwal->waktu_mulai }}">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 mt-3">Finish Time*</label>
                                <input type="time" class="form-control" name="waktu_selesai" value="{{ $jadwal->waktu_selesai }}">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-1 mt-3">Personal Trainer Name</label>
                                <input type="text" class="form-control" name="nama_pelatih" value="{{ $jadwal->nama_pelatih }}">
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-block" onclick="confirmSubmit(event)">
                                    <b>UPDATE</b>
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
                title: "Saving...",
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
