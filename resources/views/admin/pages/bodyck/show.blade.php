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
                <div class="col-sm-6 col-6">
                    <h1 class="m-0 text-lg">Body Composition</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Riwayat Body Composition</li>
                    </ol>
                </div>
                <div class="col-sm-6 col-6 text-right mt-2">
                    <a href="{{ route('user.create') }}" class="btn btn-default btn-sm border-dark">
                        <i class="fas fa-circle-plus"></i> Create
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card col-md-9 col-12 mx-auto">
                <div class="card-header">
                    <label class="card-title"><i class="fas fa-clock"></i> Riwayat Body Composition</label>
                </div>
                <div class="card-header">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered text-center">
                            <thead class="text-sm">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 10%;">Tanggal</th>
                                    <th>Nama</th>
                                    <th style="width: 20%;">No.Serial</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($bodyck as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($row->bodyck_status == 'true')
                                        <a href=""><i class="fas fa-eye"></i></a>
                                        <a href=""><i class="fas fa-edit"></i></a>
                                        @else
                                        <a href="{{ route('bodyck.detail', $row->id_bodyck) }}" class="btn btn-default btn-xs border-dark">
                                            <small><i class="fas fa-spinner text-warning"></i> <b>Proses</b></small>
                                        </a>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        {{ $row->member->nama }} <br>
                                        {{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}
                                    </td>
                                    <td>Serial No. {{ str_pad($row->no_serial, 8, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $row->bodyck_keterangan }}</td>
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

@endsection
