@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-6">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-lg">Create Schedule</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jadwal.pilih', $id) }}">Jadwal</a></li>
                        <li class="breadcrumb-item active">Create Class Schedule</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-6">
            <div class="card">
                <form id="form-jadwal" action="{{ route('jadwal.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row text-sm">
                            <div class="col-md-12 mb-2">
                                <label class="mb-1">Kelas*</label>
                                <select name="kelas_id" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $row)
                                    <option value="{{ $row->id_kelas }}">{{ $row->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
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

        const form = document.getElementById('form-jadwal');
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
                text: 'Seluruh kolom harus diisi',
                icon: 'error',
            });
        }

    }
</script>
@endsection
@endsection
