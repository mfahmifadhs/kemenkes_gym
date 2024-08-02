@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-8">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Konsultasi</small></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Konsultasi {{ $dokter->nama_dokter }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-8">
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

            <div class="card border border-dark p-2">
                <div class="card-header">
                    <label class="card-title text-sm">
                        <i class="fas fa-users text-success"></i> &nbsp; Daftar Pasien
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-dark" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive scroll" style="overflow-y: auto; max-height: 50vh;">
                                <h6 class="card-title text-xs text-secondary mt-1">
                                    <i class="fas fa-circle-check text-success"></i> Antrian Booking Konsultasi
                                </h6><br>
                                <table id="tpBook" class="table table-bordered small text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 8%;">No</th>
                                            <th style="width: 15%;">Tanggal</th>
                                            <th>Nama</th>
                                            <th>Asal</th>
                                            <th>Progres</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($book as $row)
                                        <tr class="link-cell" data-url="{{ route('konsul.detail', $row->id_konsultasi) }}">
                                            <td>
                                                <h3 class="text-info text-center"><b>{{ $loop->iteration }}</b></h3>
                                            </td>
                                            <td style="width: 0%;">
                                                {{ Carbon\Carbon::parse($row->created_at)->isoFormat('DD/MM/Y HH:mm') }}
                                            </td>
                                            <td>{{ $row->member->nama }}</td>
                                            <td>{{ $row->member->uker ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                            <td class="text-left text-xs" style="width: 0%;">
                                                @if ($row->test_sipgar == 1) <i class="fas fa-check-circle text-success"></i> tes sipgar
                                                @else <i class="fas fa-times-circle text-danger"></i> tes sipgar @endif <br>

                                                @if ($row->test_fitness == 1) <i class="fas fa-check-circle text-success"></i> tes fitness
                                                @else <i class="fas fa-times-circle text-danger"></i> tes fsitness @endif <br>

                                                @if ($row->konsultasi == 1) <i class="fas fa-check-circle text-success"></i> konsultasi
                                                @else <i class="fas fa-times-circle text-danger"></i> konsultasi @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- <table class="table table-borderless">
                                    <tbody>
                                        @if ($book->count() == 0)
                                        <div class="small text-center">
                                            Data tidak tersedia
                                        </div>
                                        @endif
                                        @foreach ($book as $row)
                                        <tr>
                                            <td>
                                                <a href="{{ route('konsul.detail', $row->id_konsultasi) }}">
                                                    <div class="card p-2 text-dark border border-dark">
                                                        <div class="row">
                                                            <div class="col-md-2 col-2 my-auto">
                                                                <h3 class="text-info text-center"><b>{{ $loop->iteration }}</b></h3>
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
                                                                        <small class="text-xs">{{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</small>
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
                                </table> -->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr class="border border-dark my-4">
                            <div class="table-responsive" style="overflow-y: auto; max-height: 50vh;">
                                <h6 class="card-title text-xs text-secondary mt-1">
                                    <i class="fas fa-circle-check text-success"></i> Antrian Konsultasi Dokter
                                </h6><br>
                                <table id="tpKonsul" class="table table-bordered small text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 0%;">No. Antrian</th>
                                            <th>Nama</th>
                                            <th>Asal</th>
                                            <th style="width: 0%;">Tanggal</th>
                                            <th style="width: 0%;">Waktu</th>
                                            <th style="width: 0%;">Progres</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($konsul as $row)
                                        <tr>
                                            <td>
                                                <h3 class="text-info text-center"><b>{{ $row->antrian_konsul }}</b></h3>
                                            </td>
                                            <td class="text-left">{{ $row->member->nama }}</td>
                                            <td>{{ $row->member->uker ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                            <td class="text-uppercase">{{ $row->tanggal_konsul ? Carbon\Carbon::parse($row->tanggal_konsul)->isoFormat('DD/MM/Y') : '' }}</td>
                                            <td>
                                                @if ($row->waktu_konsul == 1) 07.00 WIB s/d 07.20 WIB @endif
                                                @if ($row->waktu_konsul == 2) 07.20 WIB s/d 07.40 WIB @endif
                                                @if ($row->waktu_konsul == 3) 07.40 WIB s/d 08.00 WIB @endif
                                                @if ($row->waktu_konsul == 4) 08.00 WIB s/d 08.20 WIB @endif
                                                @if ($row->waktu_konsul == 5) 08.20 WIB s/d 08.40 WIB @endif
                                                @if ($row->waktu_konsul == 6) 08.40 WIB s/d 09.00 WIB @endif
                                            </td>
                                            <td class="text-left text-xs">
                                                @if ($row->test_sipgar == 1) <i class="fas fa-check-circle text-success"></i> tes sipgar
                                                @else <i class="fas fa-times-circle text-danger"></i> tes sipgar @endif <br>

                                                @if ($row->test_fitness == 1) <i class="fas fa-check-circle text-success"></i> tes fitness
                                                @else <i class="fas fa-times-circle text-danger"></i> tes fsitness @endif <br>

                                                @if ($row->konsultasi == 1) <i class="fas fa-check-circle text-success"></i> konsultasi
                                                @else <i class="fas fa-times-circle text-danger"></i> konsultasi @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- <table class="table table-borderless">
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
                                                                <h3 class="text-info text-center"><b>{{ $row->antrian_konsul }}</b></h3>
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
                                                                        <small class="text-xs">
                                                                            <i class="fa fa-calendar"></i> {{ Carbon\Carbon::parse($row->tanggal_konsul)->isoFormat('DD MMMM Y') }} &nbsp;
                                                                            <i class="fa fa-clock"></i>
                                                                            @if ($row->waktu_konsul == 1) 07.00 WIB s/d 07.20 WIB @endif
                                                                            @if ($row->waktu_konsul == 2) 07.20 WIB s/d 07.40 WIB @endif
                                                                            @if ($row->waktu_konsul == 3) 07.40 WIB s/d 08.00 WIB @endif
                                                                            @if ($row->waktu_konsul == 4) 08.00 WIB s/d 08.20 WIB @endif
                                                                            @if ($row->waktu_konsul == 5) 08.20 WIB s/d 08.40 WIB @endif
                                                                            @if ($row->waktu_konsul == 6) 08.40 WIB s/d 09.00 WIB @endif
                                                                        </small><br>
                                                                        <b>{{ strtoupper($row->member->nama) }}</b> <br>
                                                                        <small class="text-xs">
                                                                            {{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}
                                                                        </small>
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
                                </table> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border border-dark p-2">
                <div class="card-header border-dark">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-history text-success"></i> Riwayat Konsultasi
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-dark" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tKonsul" class="table table-bordered small text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>No. Antrian</th>
                                    <th>Nama</th>
                                    <th>Asal</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($konsulTrue as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('konsul.detail', $row->id_konsultasi) }}"><i class="fas fa-eye"></i></a>
                                    </td>
                                    <td>{{ $row->antrian_konsul }}</td>
                                    <td class="text-left">{{ $row->member->nama }}</td>
                                    <td class="text-left">{{ $row->member->uker ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->tanggal_konsul)->isoFormat('dddd, DD MMMM Y') }}</td>
                                    <td>
                                        @if ($row->waktu_konsul == 1) 07.00 WIB s/d 07.20 WIB @endif
                                        @if ($row->waktu_konsul == 2) 07.20 WIB s/d 07.40 WIB @endif
                                        @if ($row->waktu_konsul == 3) 07.40 WIB s/d 08.00 WIB @endif
                                        @if ($row->waktu_konsul == 4) 08.00 WIB s/d 08.20 WIB @endif
                                        @if ($row->waktu_konsul == 5) 08.20 WIB s/d 08.40 WIB @endif
                                        @if ($row->waktu_konsul == 6) 08.40 WIB s/d 09.00 WIB @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border border-dark p-2">
                <div class="card-header border-dark">
                    <label class="card-title text-sm mt-1 text-dark">
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.link-cell').forEach(function(cell) {
            cell.addEventListener('click', function() {
                window.location.href = this.getAttribute('data-url');
            });
        });
    });
</script>

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

        $("#tpBook").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true
        })

        $("#tpKonsul").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true
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

        $("#tKonsul").DataTable({
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
                    columns: [0, 2, 3, 4, 5, 6]
                },
            }, {
                extend: 'excel',
                text: ' Excel',
                className: 'bg-success',
                title: 'Riwayat Pasien',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5, 6]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tKonsul_wrapper .col-md-6:eq(0)');
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
