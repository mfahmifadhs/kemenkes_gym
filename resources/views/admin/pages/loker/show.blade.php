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
        <div class="container-fluid col-md-9 col-12 mx-auto">
            <div class="row mb-2">
                <div class="col-sm-12 col-12">
                    <h1 class="m-0 text-lg">Daftar Loker</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Loker</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="row">
                    <!-- Loker Laki-laki -->
                    <div class="col-md-12">
                        <div class="card border border-dark">
                            <div class="card-header border-dark bg-info">
                                <h3 class="card-title"><i class="fas fa-th-large"></i> Loker Pria</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-1 table-responsive">
                                <table class="table table-bordered">
                                    <tbody class="text-center">
                                        <!-- Inisialisasi counter -->
                                        @php
                                        $counter = 1;
                                        @endphp

                                        <!-- Baris -->
                                        @for ($i = 1; $i <= 3; $i++)
                                            <tr>
                                            @for ($j = 1; $j <= 12; $j++)
                                                @if ($lokerToday->where('jenis_loker', 'male')->whereNull('waktu_kembali')->count() == 0)
                                                    <td class="link-cell" data-url="{{ route('loker.no.detail', ['ctg' => 'male', 'id' => $counter]) }}">
                                                        {{ $counter }}
                                                    </td>
                                                @else
                                                    @foreach ($lokerToday->where('jenis_loker', 'male')->whereNull('waktu_kembali') as $row)
                                                        @if ($row->no_loker == $counter)
                                                        <td class="link-cell bg-danger" data-url="{{ route('loker.no.detail', ['ctg' => 'male', 'id' => $counter]) }}">
                                                            {{ $counter }}
                                                        </td>
                                                        @else
                                                        <td class="link-cell" data-url="{{ route('loker.no.detail', ['ctg' => 'male', 'id' => $counter]) }}">
                                                            {{ $counter }}
                                                        </td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endfor
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Loker Perempuan -->
                    <div class="col-md-12">
                        <div class="card border border-dark">
                            <div class="card-header border-dark bg-pink">
                                <h3 class="card-title"><i class="fas fa-th-large"></i> Loker Perempuan</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body table-responsive">
                                <table class="table table-bordered">
                                    <tbody class="text-center">
                                        <!-- Inisialisasi counter -->
                                        @php
                                        $counter = 1;
                                        @endphp

                                        <!-- Baris -->
                                        @for ($i = 1; $i <= 3; $i++)
                                            <tr>
                                            @for ($j = 1; $j <= 15; $j++)
                                                @if ($lokerToday->where('jenis_loker', 'female')->whereNull('waktu_kembali')->count() == 0)
                                                    <td class="link-cell" data-url="{{ route('loker.no.detail', ['ctg' => 'female', 'id' => $counter]) }}">
                                                        {{ $counter }}
                                                    </td>
                                                @else
                                                    @foreach ($lokerToday->where('jenis_loker', 'female')->whereNull('waktu_kembali') as $row)
                                                        @if ($row->no_loker == $counter)
                                                        <td class="link-cell bg-danger" data-url="{{ route('loker.no.detail', ['ctg' => 'female', 'id' => $counter]) }}">
                                                            {{ $counter }}
                                                        </td>
                                                        @else
                                                        <td class="link-cell" data-url="{{ route('loker.no.detail', ['ctg' => 'female', 'id' => $counter]) }}">
                                                            {{ $counter }}
                                                        </td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endfor
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card border border-dark">
                            <div class="card-header border-dark">
                                <label class="card-title">
                                    <h6 class="text-xs mb-0">{{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</h6>
                                    Pemakaian Loker
                                </label>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool text-dark mt-2" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body rounded">
                                <div class="table-responsive">
                                    <table id="tLokerToday" class="table table-bordered text-center small">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Asal</th>
                                                <th>No. Loker</th>
                                                <th>Waktu Pinjam</th>
                                                <th>Waktu Kembali</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lokerToday as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $row->member->nama }}</td>
                                                <td>{{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                                <td class="text-md"><b>{{ $row->no_loker }}</b></td>
                                                <td>{{ Carbon\Carbon::parse($row->created_at)->format('H:i:s') }}</td>
                                                <td>{{ $row->waktu_kembali }}</td>
                                                <td>
                                                    @if ($row->jenis_loker == 'male') <span class="badge badge-info">Laki-laki</span> @endif
                                                    @if ($row->jenis_loker == 'female') <span class="badge badge-pink">Perempuan</span> @endif
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
        let today = '{{ Carbon\Carbon::now() }}'
        $("#tLokerToday").DataTable({
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
                className: 'rounded bg-danger',
                title: 'Loker - ' + today,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                },
            }, {
                extend: 'excel',
                text: ' Download Xls',
                pageSize: 'A4',
                className: 'ml-1 rounded bg-success',
                title: 'Loker - ' + today,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tLokerToday_wrapper .col-md-6:eq(0)');

        $("#tLoker").DataTable({
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
                className: 'rounded bg-danger',
                title: 'Loker - ' + today,
                exportOptions: {
                    columns: [2, 3, 4, 5, 6, 7]
                },
            }, {
                extend: 'excel',
                text: ' Download Xls',
                pageSize: 'A4',
                className: 'ml-1 rounded bg-success',
                title: 'Loker - ' + today,
                exportOptions: {
                    columns: [2, 3, 4, 5, 6, 7]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tLoker_wrapper .col-md-6:eq(0)');
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
