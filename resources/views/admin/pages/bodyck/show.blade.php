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
        <div class="container-fluid col-md-12 col-12 mx-auto">
            <div class="row mb-2">
                <div class="col-sm-6 col-6">
                    <h1 class="m-0 text-lg">Body Composition</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Body Composition</li>
                    </ol>
                </div>
                @if (Auth::user()->role_id == 1)
                <div class="col-sm-6 col-6 text-right mt-2">
                    <a href="" class="btn btn-default btn-sm border-dark">
                        <i class="fas fa-circle-plus"></i> Create
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-12 col-12 mx-auto">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-sm mb-2"><i class="fas fa-fire"></i> Top 10 Best Progress Fat Loss</div>
                                @foreach (collect($topFatLoss)->sortBy('progress') as $row)
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1">
                                        <h2 class="font-weight-bold mt-2">{{ $loop->iteration }}</h2>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text small">
                                            <h6>{{ ucwords(strtolower($row['nama'])) }} <br>
                                                <small>{{ Str::limit($row['uker'], 40) }}</small>
                                            </h6>
                                        </span>
                                        <span class="info-box-number">
                                            <b>{{ $row['progress'] }} <small class="text-xs">%</small></b>
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <div class="text-sm mb-2"><i class="fas fa-fire"></i> Top 10 Best Progress Muscle Mass</div>
                                @foreach (collect($topMuscleMass)->sortBy('progress') as $row)
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1">
                                        <h2 class="font-weight-bold mt-2">{{ $loop->iteration }}</h2>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text small">
                                            <h6>{{ ucwords(strtolower($row['nama'])) }} <br>
                                                <small>{{ Str::limit($row['uker'], 40) }}</small>
                                            </h6>
                                        </span>
                                        <span class="info-box-number">
                                            <b>{{ $row['progress'] }} <small class="text-xs">%</small></b>
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="text-sm mb-2"><i class="fas fa-weight-scale"></i> Body Composition</div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="table table-bordered text-center">
                                        <thead class="text-sm">
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th>Nama</th>
                                                <th style="width: 10%;">Pengecekan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm">
                                            @foreach($user as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">
                                                    {{ $row->nama }} <br>
                                                    {{ $row->instansi == 'pusat' ? $row->uker?->nama_unit_kerja : $row->nama_instansi }}
                                                </td>
                                                <td>
                                                    @foreach ($row->bodyCk as $no => $subRow)
                                                    <a href="">
                                                        <span class="text-success">
                                                            <i class="fas fa-check-circle"></i> Tanita {{ $no+1 }} - {{ Carbon\Carbon::parse($subRow->tanggal_cek)->format('d-m-Y') }}
                                                        </span><br>
                                                    </a>
                                                    @endforeach
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

@endsection
