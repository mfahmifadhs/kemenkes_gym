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
                    <h1 class="m-0 text-lg">Fat Loss & Muscle Gain Challenge</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Challenge</li>
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
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-sm mb-2"><i class="fas fa-fire"></i> Top 3 Fat Loss</div>
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
                                @if (!collect($topFatLoss)->count())
                                <div class="mt-2 mb-4">Tidak ada data</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-sm mb-2"><i class="fas fa-weight-scale"></i> Fat Loss Participant</div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tFatLoss" class="table table-bordered text-center">
                                        <thead class="text-sm">
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th>Nama</th>
                                                <th>Asal</th>
                                                <th style="width: 10%;">Pengecekan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm">
                                            @foreach($challenge as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $row->member->nama }} </td>
                                                <td class="text-left">
                                                    {{ $row->member->instansi == 'pusat' ? $row->member->uker?->nama_unit_kerja : $row->member->nama_instansi }}
                                                </td>
                                                <td>
                                                    @foreach ($row->bodyCp as $noTanita => $subRow)
                                                    <a href="" data-toggle="modal" data-target="#detail-{{ $subRow->id_bodyck }}">
                                                        <span class="text-success">
                                                            <i class="fas fa-check-circle"></i> Tanita {{ $noTanita+1 }} - {{ Carbon\Carbon::parse($subRow->tanggal_cek)->format('d-m-Y') }}
                                                        </span><br>
                                                    </a>
                                                    @foreach ($challenge->bodyp->where('bodyck_id', $subRow->id_bodyck) as $detail)
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="detail-{{ $subRow->id_bodyck }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Tanita {{ $noTanita+1 }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <label class="col-md-5">Nama</label>
                                                                        <div class="col-md-1">:</div>
                                                                        <div class="col-md-5">{{ $row->nama }}</div>
                                                                        <label class="col-md-5">Asal Instansi/Unit Kerja</label>
                                                                        <div class="col-md-1">:</div>
                                                                        <div class="col-md-6">{{ $row->instansi == 'pusat' ? $row->uker->nama_unit_kerja : $row->nama_instansi }}</div>
                                                                    </div>
                                                                    <hr>
                                                                    @foreach ($bodyckParam as $rowParam)
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>{{ $rowParam->nama_param }}</label>
                                                                        </div>
                                                                        <div class="col-md-1">:</div>
                                                                        <div class="col-md-6">
                                                                            {{ $detail->firstWhere('param_id', $rowParam->id_param)->nilai }} {{ $rowParam->satuan }}
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
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
                    <!-- Muscle Gain -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-sm mb-2"><i class="fas fa-fire"></i> Top 3 Best Muscle Gain</div>
                                @foreach (collect($topMuscleGain)->sortBy('progress') as $row)
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
                                @if (!collect($topMuscleGain)->count())
                                <div class="mt-2 mb-4">Tidak ada data</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-sm mb-2"><i class="fas fa-weight-scale"></i> Muscle Gain Participant</div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tMuscleGain" class="table table-bordered text-center">
                                        <thead class="text-sm">
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th>Nama</th>
                                                <th>Asal</th>
                                                <th style="width: 10%;">Pengecekan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm">
                                            @foreach($challenge as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $row->member->nama }}</td>
                                                <td class="text-left">
                                                    {{ $row->member->instansi == 'pusat' ? $row->member->uker?->nama_unit_kerja : $row->member->nama_instansi }}
                                                </td>
                                                <td>
                                                    @foreach ($row->bodyCp as $noTanita => $subRow)
                                                    <a href="" data-toggle="modal" data-target="#detail-{{ $subRow->id_bodyck }}">
                                                        <span class="text-success">
                                                            <i class="fas fa-check-circle"></i> Tanita {{ $noTanita+1 }} - {{ Carbon\Carbon::parse($subRow->tanggal_cek)->format('d-m-Y') }}
                                                        </span><br>
                                                    </a>
                                                    @foreach ($challenge->bodyp->where('bodyck_id', $subRow->id_bodyck) as $detail)
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="detail-{{ $subRow->id_bodyck }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Tanita {{ $noTanita+1 }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <label class="col-md-5">Nama</label>
                                                                        <div class="col-md-1">:</div>
                                                                        <div class="col-md-5">{{ $row->nama }}</div>
                                                                        <label class="col-md-5">Asal Instansi/Unit Kerja</label>
                                                                        <div class="col-md-1">:</div>
                                                                        <div class="col-md-6">{{ $row->instansi == 'pusat' ? $row->uker->nama_unit_kerja : $row->nama_instansi }}</div>
                                                                    </div>
                                                                    <hr>
                                                                    @foreach ($bodyckParam as $rowParam)
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label>{{ $rowParam->nama_param }}</label>
                                                                        </div>
                                                                        <div class="col-md-1">:</div>
                                                                        <div class="col-md-6">
                                                                            {{ $detail->firstWhere('param_id', $rowParam->id_param)->nilai }} {{ $rowParam->satuan }}
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
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

@section('js')
<script>
    $(function() {
        var currentdate = new Date();
        var datetime = "Tanggal: " + currentdate.getDate() + "/" +
            (currentdate.getMonth() + 1) + "/" +
            currentdate.getFullYear() + " \n Pukul: " +
            currentdate.getHours() + ":" +
            currentdate.getMinutes() + ":" +
            currentdate.getSeconds()

        $("#tFatLoss").DataTable({
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
                className: 'bg-danger mr-2 rounded btn-sm',
                title: 'fatloss',
                exportOptions: {
                    columns: [0, 1, 2]
                },
            }, {
                extend: 'excel',
                text: ' Excel',
                pageSize: 'A4',
                className: 'bg-success btn-sm rounded',
                title: 'fatloss',
                exportOptions: {
                    columns: [0, 1, 2]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tFatLoss_wrapper .col-md-6:eq(0)');

        $("#tMuscleGain").DataTable({
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
                className: 'bg-danger mr-2 rounded btn-sm',
                title: 'musclegain',
                exportOptions: {
                    columns: [0, 1, 2]
                },
            }, {
                extend: 'excel',
                text: ' Excel',
                pageSize: 'A4',
                className: 'bg-success btn-sm rounded',
                title: 'musclegain',
                exportOptions: {
                    columns: [0, 1, 2]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tMuscleGain_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection

@endsection
