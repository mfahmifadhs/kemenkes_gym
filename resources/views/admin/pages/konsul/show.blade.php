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

            <div class="card p-2">
                <div class="card-header mb-3">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-circle-check text-success"></i> Daftar Pasien Aktif
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>

                            @if ($konsul->count() == 0)
                            <div class="small text-center">
                                Data tidak tersedia
                            </div>
                            @endif
                            @foreach ($konsul as $row)
                            <tr>
                                <td>
                                    <a href="{{ route('konsul.detail', $row->id_konsultasi) }}">
                                        <div class="card p-2 text-dark border border-dark">
                                            <div class="row">
                                                <div class="col-md-2 col-2 my-auto">
                                                    <h3 class="text-info text-center"><b>{{ $row->kode_book }}</b></h3>
                                                </div>
                                                <div class="col-md-10 col-10">
                                                    <h6 class="text-xs">
                                                        <span>
                                                            @if ($row->test_sipgar == 1) <i class="fas fa-check-circle text-success"></i> Test Sipgar
                                                            @else <i class="fas fa-times-circle text-danger"></i> Test Sipgar @endif

                                                            @if ($row->test_fitness == 1) <i class="fas fa-check-circle text-success ml-1"></i> Test Fitness
                                                            @else <i class="fas fa-times-circle text-danger ml-1"></i> Test Fitness @endif

                                                            @if ($row->konsultasi == 1) <i class="fas fa-check-circle text-success ml-1"></i> Konsultasi
                                                            @else <i class="fas fa-times-circle text-danger ml-1"></i> Konsultasi @endif
                                                        </span>
                                                    </h6>
                                                    <h6 class="text-xs">
                                                        <h6>
                                                            <small class="text-xs">{{ $row->created_at }}</small><br>
                                                            <b>{{ strtoupper($row->member->nama) }}</b> <br>
                                                            <small>{{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</small>
                                                        </h6>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table><hr>
                    <div class="row">
                        <div class="col-md-12 col-12 mx-2">
                            Total: {{ number_format($konsul->total(), 0, ',', '.') }}
                            Current page: {{ $konsul->count()}}

                            <div class="mt-2">{{ $konsul->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-2">
                <div class="card-header">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-history text-success"></i> Riwayat Daftar Pasien
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-history" class="table table-bordered small text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Nama</th>
                                    <th>Asal</th>
                                    <th>Total Konsul</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('konsul.user.detail', $row->id) }}"><i class="fas fa-eye"></i></a>
                                        @if (Auth::user()->role_id == 1)
                                        <a href="{{ route('konsul.user.delete', $row->id) }}"><i class="fas fa-trash"></i></a>
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $row->nama }}</td>
                                    <td class="text-left">{{ $row->instansi == 'pusat' ? $row->uker->nama_unit_kerja : $row->nama_instansi }}</td>
                                    <td>{{ $row->konsul->count() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
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
            "autoWidth": false,
            "info": true,
            "paging": true,
            "searching": true,
            buttons: [{
                extend: 'pdf',
                text: ' PDF',
                pageSize: 'A4',
                className: 'bg-danger',
                title: 'Riwayat Pasien',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                },
            }, {
                extend: 'excel',
                text: ' Excel',
                className: 'bg-success',
                title: 'Riwayat Pasien',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#table-history_wrapper .col-md-6:eq(0)');
    })

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
