@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-6">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> {{ $kelas->nama_kelas }}</small></h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('kelas') }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
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
                                <img src="{{ asset('dist/img/class/'. $kelas->img_icon) }}" class="text-primary w-50 img-circle">
                            </h3>
                        </div>
                        <div class="col-md-8">
                            <label class="text-secondary text-sm mb-0">
                                <a href="{{ route('kelas.edit', $kelas->id_kelas) }}"><i class="fas fa-edit"></i></a>
                                <i>Informasi Kelas</i>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Nama</label>
                                    <h6 class="text-sm">{{ $kelas->nama_kelas }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Status</label>
                                    <h6 class="text-sm">{{ $kelas->status }}</h6>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <label class="mb-0 text-sm">Deskripsi</label>
                                    <h6 class="text-sm text-capitalize mb-0">{{ $kelas->deskripsi }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-circle-check text-success"></i> Kelas Aktif
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('jadwal.create', $kelas->id_kelas) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle"></i> Tambah Kelas
                        </a>
                        <table id="table-history" class="table table-bordered text-xs text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Tanggal Kelas</th>
                                    <th>Waktu</th>
                                    <th>Kuota</th>
                                    <th>Pelatih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->jadwal->sortByDesc('tanggal_kelas')->where('tanggal_kelas', '>=', \Carbon\Carbon::now()->format('Y-m-d')) as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('jadwal.detail', $row->id_jadwal) }}"><i class="fas fa-eye mx-1"></i></a>
                                        <a href="{{ route('jadwal.edit', $row->id_jadwal) }}"><i class="fas fa-pencil mx-1"></i></a>
                                    </td>
                                    <td>{{ $row->tanggal_kelas }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->waktu_mulai)->isoFormat('HH.mm').' - '.Carbon\Carbon::parse($row->waktu_selesai)->isoFormat('HH.mm') }}</td>
                                    <td>{{ $row->peserta->where('tanggal_latihan', $row->tanggal_kelas)->count() .' / '. $row->kuota }}</td>
                                    <td>{{ $row->nama_pelatih }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-users"></i> Peminat Kelas
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-member" class="table table-bordered text-xs text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Member ID</th>
                                    <th>Nama</th>
                                    <th>Unit kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->minat as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('member.detail', $row->member_id) }}"><i class="fas fa-eye mx-1"></i></a>
                                        <a href="{{ route('member.deleteMinat', $row->id_minat_kelas) }}" onclick="confirmRemove(event, `{{ route('member.deleteMinat', $row->id_minat_kelas) }}`)">
                                            <i class="fas fa-trash mx-1"></i>
                                        </a>
                                    </td>
                                    <td>{{ $row->member?->member_id }}</td>
                                    <td class="text-left">{{ $row->member?->nama }}</td>
                                    <td class="text-left">{{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-history text-warning"></i> Riwayat Kelas
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-active" class="table table-bordered text-xs text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Tanggal Kelas</th>
                                    <th>Waktu</th>
                                    <th>Kuota</th>
                                    <th>Pelatih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->jadwal->sortByDesc('tanggal_kelas') as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('jadwal.detail', $row->id_jadwal) }}"><i class="fas fa-eye mx-1"></i></a>
                                        <a href="{{ route('kelas.edit', $row->id_jadwal) }}"><i class="fas fa-pencil mx-1"></i></a>
                                    </td>
                                    <td>{{ $row->tanggal_kelas }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->waktu_mulai)->isoFormat('HH.mm').' - '.Carbon\Carbon::parse($row->waktu_selesai)->isoFormat('HH.mm') }}</td>
                                    <td>{{ $row->peserta->where('tanggal_latihan', $row->tanggal_kelas)->count() .' / '. $row->kuota }}</td>
                                    <td>{{ $row->nama_pelatih }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><br>
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
