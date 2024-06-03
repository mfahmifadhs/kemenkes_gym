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
        <div class="container-fluid col-md-6 col-12 mx-auto">
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
            <div class="card col-md-6 col-12 mx-auto">
                <div class="card-header">
                    <label class="card-title">
                        <small><i class="fas fa-clock"></i> Riwayat Body Composition </small>
                    </label>
                </div>
                <div class="card-header">
                    <form id="form" action="{{ route('bodyck.update', $bodyck->id_bodyck) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label class="small">Date*</label>
                                <input type="datetime-local" class="form-control" name="tanggal" value="{{ Carbon\Carbon::parse($bodyck->tanggal_cek)->isoFormat('Y-MM-DD HH:mm') }}">
                            </div>
                            <div class="form-group col-md-6 col-6">
                                <label class="small">Body Type*</label>
                                <select name="tipe_badan" class="form-control" required>
                                    <option value="std">Standard</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-6">
                                <label class="small">Serial Number*</label>
                                <input type="number" class="form-control" name="no_serial" value="{{ $bodyck->no_serial }}">
                            </div>
                            <div class="form-group col-md-6 col-6">
                                <label class="small">Height*</label>
                                <input id="tinggi" type="number" class="form-control" name="bodyck_tinggi" value="{{ $bodyck->bodyck_tinggi }}">
                            </div>
                            <div class="form-group col-md-6 col-6">
                                <label class="small">Clothes Weight (kg)*</label>
                                <input type="number" class="form-control" name="berat_baju" value="{{ $bodyck->berat_baju }}">
                            </div>
                            <div class="form-group col-md-12 col-12 mb-0">
                                <label class="section-title mb-2 "><small>Result</small></label>
                            </div>
                            <div class="form-group col-md-12 col-12 mb-0">
                                <div class="row">
                                    @foreach ($bodyck->detail as $i => $row)
                                    <div class="col-md-4 mb-2 col-form-label ">{{ $loop->iteration.'. '.$row->param->nama_param .' '. $row->param->satuan }}*</div>
                                    <div class="col-md-8 mb-2">
                                        <input type="hidden" name="id_detail[]" value="{{ $row->id_detail }}" required>
                                        <input type="hidden" name="key[]" value="{{ $row->param_id }}" required>
                                        <input type="number" class="form-control" id="val_{{ $row->param_id }}" name="val_{{ $row->param_id }}" value="{{ $row->nilai }}" required>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <div class="row">
                                <div class="col-md-4 mb-2 col-form-label ">15. Upload file*</div>
                                    <div class="col-md-8 mb-2">
                                        <input type="hidden" name="id_detail[]" value="{{ $row->id_detail }}" required>
                                        <input type="hidden" name="key[]" value="{{ $row->param_id }}" required>
                                        <input type="number" class="form-control" id="val_{{ $row->param_id }}" name="val_{{ $row->param_id }}" value="{{ $row->nilai }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block mt-3" onclick="confirmSubmit(event)">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div><br>
</div>

@endsection
