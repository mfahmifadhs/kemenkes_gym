@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-6">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"> Konsultasi</small></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Konsultasi {{ $dokter->nama_dokter }}</li>
                    </ol>
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
                            <h3 class="text-center p-2">
                                <img src="{{ asset('dist/img/'. $dokter->foto_dokter) }}" class="text-primary w-50 img-circle">
                            </h3>
                        </div>
                        <div class="col-md-8">
                            <label class="text-secondary text-sm mb-0">
                                <i>Konsultasi</i>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Nama Dokter</label>
                                    <h6 class="text-sm">{{ $dokter->nama_dokter }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Spesialisasi</label>
                                    <h6 class="text-sm">{{ $dokter->spesialisasi }}</h6>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <label class="mb-0 text-sm">Profil Dokter</label>
                                    <h6 class="text-sm text-capitalize mb-0">{{ $dokter->profil_dokter }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-circle-check text-success"></i> Daftar Pasien
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                @foreach ($konsul as $row)
                                <tr>
                                    <td style="width: 10%;">
                                        <h3 class="text-info"><b>{{ $loop->iteration }}</b></h3>
                                    </td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#modal-{{ $row->id_konsul }}">
                                            <div class="card mt-2 p-2 text-dark">
                                                <h6 class="text-xs">
                                                    <span class="mr-1">
                                                        @if ($row->test_sipgar == 1) <i class="fas fa-check-circle text-success"></i> Test Sipgar
                                                        @else <i class="fas fa-times-circle text-danger"></i> Test Sipgar @endif

                                                        @if ($row->test_fitness == 1) <i class="fas fa-check-circle text-success"></i> Test Fitness
                                                        @else <i class="fas fa-times-circle text-danger"></i> Test Fitness @endif

                                                        @if ($row->konsultasi == 1) <i class="fas fa-check-circle text-success"></i> Konsultasi
                                                        @else <i class="fas fa-times-circle text-danger"></i> Konsultasi @endif
                                                    </span>
                                                </h6>
                                                <h6 class="text-xs pt-2">
                                                    {{ Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMMM Y || HH:mm') }} <br>
                                                    {{ $row->member->nama }} <br>
                                                    {{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}
                                                </h6>
                                            </div>
                                        </a>

                                        <div class="modal fade" id="modal-{{ $row->id_konsul }}" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form id="form" action="{{ route('konsul.update', $row->id_konsultasi) }}" method="GET">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-md" id="modal-{{ $row->id_konsul }}">
                                                                {{ $loop->iteration.' - '.$row->member->nama }} <br>
                                                                <small style="margin-left: 13%;">
                                                                    {{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}
                                                                </small>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-4 col-4">1. Test Sipgar</div>
                                                                <div class="col-md-8 col-8">:
                                                                    <!-- Test Sipgar -->
                                                                    <input id="true-sipgar" type="radio" name="test[1]" class="ml-2" value="1" {{ $row->test_sipgar == true ? 'checked' : '' }}>
                                                                    <label for="true-sipgar"><i class="fa fa-check-circle text-xs text-success"></i> sudah</label>

                                                                    <input id="false-sipgar" type="radio" name="test[1]" class="ml-2" value="0" {{ $row->test_sipgar == false ? 'checked' : '' }}>
                                                                    <label for="false-sipgar"><i class="fa fa-times-circle text-xs text-danger"></i> belum</label>
                                                                </div>


                                                                <div class="col-md-4 col-4">2. Test Fitness</div>
                                                                <div class="col-md-8 col-8">:
                                                                    <!-- Test Fitness -->
                                                                    <input id="true-fitness" type="radio" name="test[2]" class="ml-2" value="1" {{ $row->test_fitness == true ? 'checked' : '' }}>
                                                                    <label for="true-fitness"><i class="fa fa-check-circle text-xs text-success"></i> sudah</label>

                                                                    <input id="false-fitness" type="radio" name="test[2]" class="ml-2" value="0" {{ $row->test_fitness == false ? 'checked' : '' }}>
                                                                    <label for="false-fitness"><i class="fa fa-times-circle text-xs text-danger"></i> belum</label>
                                                                </div>

                                                                <div class="col-md-12 col-12 mt-3">Konsultasi :</div>
                                                                <div class="col-md-12 col-12 text-sm mt-3">
                                                                    <label for="catatan_dokter">
                                                                        Catatan Dokter <br>
                                                                        <span class="text-danger" style="font-size: 10px;">
                                                                            Catatan bersifat rahasia, dan tidak akan diberitahukan kepada pasien
                                                                        </span>
                                                                    </label>
                                                                    <textarea name="catatan_dokter" class="form-control" id="catatan_dokter" rows="5">{{ $row->catatan_dokter }}</textarea>
                                                                </div>
                                                                <div class="col-md-12 col-12 text-sm mt-3">
                                                                    <label for="catatan_pasien">Catatan Pasien</label>
                                                                    <textarea name="catatan_pasien" class="form-control" id="catatan_pasien" rows="5">{{ $row->catatan_pasien }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary btn-sm btn-info" onclick="confirmSubmit(event)">
                                                                <i class="fa fa-save"></i> Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $(function() {
        $("#table-active").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": false,
            "paging": false,
            "searching": false
        })

        $("#table-history").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": false,
            "paging": false,
            "searching": false
        })

        $("#table-member").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true
        })
    })

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

    function confirmRemove(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus ?',
            text: 'Hapus peserta peminatan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection
@endsection
