@extends('admin.layout.app')

@section('content')

@if (Session::has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ Session::get("success") }}',
    });
</script>
@endif


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-8 col-12 mx-auto">
            <div class="row mb-2">
                <div class="col-sm-12 col-12">
                    <h1 class="m-0 text-lg">Detail Loker {{ $id }} - {{ $kategori }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('loker.show') }}">Daftar Loker</a></li>
                        <li class="breadcrumb-item active">Detail Loker</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-8 col-12 mx-auto">
                <div class="row">
                    @if ($pengguna)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <label class="card-title text-sm mt-1">
                                    <h6 class="text-xs mb-0">Loker {{ $id }} - {{ $kategori }}</h6>
                                    Pengguna Loker
                                </label>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool text-dark mt-2" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body rounded">
                                <div class="input-group">
                                    <label style="width: 10%;">Nama</label>
                                    <div style="width: 30%;">: {{ $pengguna->member->nama }}</div>

                                    <label style="width: 15%;">Asal</label>
                                    <div>: {{ $pengguna->member->uker ? $pengguna->member->uker->nama_unit_kerja : $pengguna->member->nama_instansi }}</div>
                                </div>
                                <div class="input-group">
                                </div>
                                <div class="input-group">
                                    <label style="width: 10%;">Tanggal</label>
                                    <div style="width: 30%;">: {{ Carbon\Carbon::parse($pengguna->created_at)->isoFormat('dddd, DD MMMM Y') }}</div>

                                    <label style="width: 15%;">Waktu Pinjam</label>
                                    <div>: {{ Carbon\Carbon::parse($pengguna->created_at)->format('H:i:s') }}</div>
                                </div>
                                <div class="input-group">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <label class="card-title text-sm mt-1">
                                    <h6 class="text-xs mb-0">Loker {{ $id }} - {{ $kategori }}</h6>
                                    Riwayat Pengguna Loker
                                </label>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool text-dark mt-2" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body rounded">
                                <div class="table-responsive">
                                    <table id="tdetail" class="table table-bordered small text-center">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Nama</th>
                                                <th>Asal</th>
                                                <th>Tanggal</th>
                                                <th>Waktu Pinjam</th>
                                                <th>Waktu Kembali</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($riwayat as $row)
                                            <tr>
                                                <td>
                                                    <a href="" onclick="confirmRemove(event, '<?php echo route('loker.riwayat.delete', $row->id_peminjaman); ?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $loop->iteration }}. {{ $row->member->nama }}</td>
                                                <td>{{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                                <td>{{ Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                                                <td>{{ Carbon\Carbon::parse($row->created_at)->format('H:i:s') }}</td>
                                                <td>{{ $row->waktu_kembali }}</td>
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
        </div>
    </div><br>
</div>

@section('js')
<script>
    $(function() {
        let id  = '{{ $id }}'
        let ctg = '{{ $kategori }}'
        $("#tdetail").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            buttons: [{
                extend: 'pdf',
                text: ' Print PDF',
                pageSize: 'A4',
                className: 'bg-danger',
                title: 'Loker - ' + id + ' - ' + ctg,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tdetail_wrapper .col-md-6:eq(0)');
    })
</script>

<script>
    function confirmRemove(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus ?',
            text: 'Hapus data peminjam',
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
