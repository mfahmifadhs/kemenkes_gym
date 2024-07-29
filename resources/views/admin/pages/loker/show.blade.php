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
                            <div class="card-body p-1">
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
                                            <td>{{ $counter }}</td>
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

                            <div class="card-body p-1">
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
                                            <td>{{ $counter }}</td>
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
                        <div class="card">
                            <div class="card-header">
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
                            <div class="card-body p-1 rounded">
                                <table class="table table-bordered text-center small">
                                    <thead>
                                        <tr>
                                            <th style="width: 0%;">No</th>
                                            <th>Nama</th>
                                            <th>Asal</th>
                                            <th>Waktu Pinjam</th>
                                            <th>Waktu Kembali</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lokerToday as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->member->nama }}</td>
                                            <td>{{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
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
    </div><br>
</div>

@endsection
