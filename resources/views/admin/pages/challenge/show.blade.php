@extends('admin.layout.app')

@section('content')

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

                <div class="col-sm-6 col-6 text-right mt-2">
                    <a href="#" class="btn btn-default btn-sm border-dark" data-toggle="modal" data-target="#tambah">
                        <i class="fas fa-plus-circle"></i> Tambah Peserta
                    </a>
                    <a href="{{ route('challenge.leaderboard') }}" class="btn btn-default btn-sm border-dark">
                        <i class="fas fa-ranking-star"></i> Leaderboard
                    </a>
                    <a href="#" class="btn btn-default btn-sm border-dark" data-toggle="modal" data-target="#filter">
                        <i class="fas fa-filter"></i> Filter
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-12 col-12 mx-auto">
                <div class="row">
                    <div class="col-md-12">
                        @if ($message = Session::get('success'))
                        <div id="alert" class="alert bg-success">
                            <p style="color:white;margin: auto;">{{ $message }}</p>
                        </div>

                        <script>
                            setTimeout(function() {
                                document.getElementById('alert').style.display = 'none';
                            }, 10000);
                        </script>
                        @endif

                        @if ($message = Session::get('failed'))
                        <div id="alert" class="alert bg-failed">
                            <p style="color:white;margin: auto;">{{ $message }}</p>
                        </div>

                        <script>
                            setTimeout(function() {
                                document.getElementById('alert').style.display = 'none';
                            }, 10000);
                        </script>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="card border border-dark">
                            <div class="card-header border-dark">
                                <h6 class="card-title">
                                    <small class="font-weight-bold">
                                        <i class="fas fa-weight-scale"></i> Fat Loss Participant
                                    </small>
                                </h6>
                                <div class="card-tools">
                                    Total : {{ $challenge->where('challenge_id', 1)->count() }}
                                </div>
                            </div>
                            <div class="card-body border-dark">
                                <div class="table-responsive">
                                    <table id="tFatLoss" class="table table-bordered text-center">
                                        <thead class="text-xs">
                                            <tr>
                                                <th style="width: 0%;">No</th>
                                                <th style="width: 5%;">Aksi</th>
                                                <th style="width: 10%;">Tanita</th>
                                                <th style="width: 5%;">Gender</th>
                                                <th>Nama</th>
                                                <th>Asal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-xs">
                                            @foreach($challenge->where('challenge_id', 1) as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('challenge.participant.detail', $row->member_id) }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                    <a href="" onclick="confirmRemove(event, `{{ route('challenge.participant.delete', $row->id_detail) }}`)">
                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                    </a>
                                                    <a href="#" type="button" data-toggle="modal" data-target="#modal-{{ $row->id_detail }}">
                                                        <i class="fas fa-edit text-success"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($row->member->bodycp()->whereBetween(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(tanggal_cek, ' ', 1), '%d/%m/%Y')"), ['2024-08-05', '2024-08-20'])->count() != 0)
                                                    <b><i class="fas fa-check-circle text-success"></i> Tahap 1</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($row->member->jenis_kelamin == 'male')
                                                    <span class="badge badge-success">Pria</span>
                                                    @else
                                                    <span class="badge badge-pink">Wanita</span>
                                                    @endif
                                                </td>
                                                <td class="text-left">{{ $row->member->nama }} </td>
                                                <td class="text-left">
                                                    {{ $row->member->instansi == 'pusat' ? $row->member->uker?->nama_unit_kerja : $row->member->nama_instansi }}

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
                        <hr>
                        <!-- Man Top 3 Fat Loss -->
                        <div class="text-sm text-primary font-weight-bold mb-2">
                            <i class="fas fa-fire"></i> Man Top 3 Fat Loss
                        </div>
                        <div class="row">
                            @for ($i = 1; $i <= 3; $i++) <div class="col-md-4 col-4">
                                <div class="card border border-dark">
                                    <div class="card-header border-dark text-center p-2">
                                        <h3 class="font-weight-bold text-info mb-0">{{ $i }}</h3>
                                    </div>
                                    <div class="card-body border-dark p-1">
                                        <h6 class="text-center text-sm">
                                            <small>Nama</small><br>
                                            <small>Asal</small><br>
                                            <small><b>3%</b></small>
                                        </h6>
                                    </div>
                                </div>
                        </div>
                        @endfor
                    </div>
                </div>
                <!-- Muscle Gain -->
                <div class="col-md-6">
                    <div class="card border border-dark">
                        <div class="card-header border-dark">
                            <h6 class="card-title">
                                <small class="font-weight-bold">
                                    <i class="fas fa-weight-scale"></i> Muscle Gain Participant
                                </small>
                            </h6>
                            <div class="card-tools">
                                Total : {{ $challenge->where('challenge_id', 2)->count() }}
                            </div>
                        </div>
                        <div class="card-body border-dark">
                            <div class="table-responsive">
                                <table id="tMuscleGain" class="table table-bordered text-center">
                                    <thead class="text-sm">
                                        <tr>
                                            <th style="width: 0%;">No</th>
                                            <th style="width: 5%;">Aksi</th>
                                            <th style="width: 10%;">Aksi</th>
                                            <th style="width: 5%;">Gander</th>
                                            <th>Nama</th>
                                            <th>Asal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-xs">
                                        @foreach($challenge->where('challenge_id', 2) as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('challenge.participant.detail', $row->member_id) }}">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                                <a href="" onclick="confirmRemove(event, `{{ route('challenge.participant.delete', $row->id_detail) }} `)">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </a>
                                                <a href="#" type="button" data-toggle="modal" data-target="#modal-{{ $row->id_detail }}">
                                                    <i class="fas fa-edit text-success"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if ($row->member->bodycp()->whereBetween(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(tanggal_cek, ' ', 1), '%d/%m/%Y')"), ['2024-08-05', '2024-08-20'])->count() != 0)
                                                <b><i class="fas fa-check-circle text-success"></i> Tahap 1</b>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->member->jenis_kelamin == 'male')
                                                <span class="badge badge-success">Pria</span>
                                                @else
                                                <span class="badge badge-pink">Wanita</span>
                                                @endif
                                            </td>
                                            <td class="text-left">{{ $row->member->nama }}</td>
                                            <td class="text-left">
                                                {{ $row->member->instansi == 'pusat' ? $row->member->uker?->nama_unit_kerja : $row->member->nama_instansi }}

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

                    <hr>
                    <!-- Man Top 3 Fat Loss -->
                    <div class="text-sm text-primary font-weight-bold mb-2">
                        <i class="fas fa-fire"></i> Man Top 3 Muscle Gain
                    </div>
                    <div class="row">
                        @for ($i = 1; $i <= 3; $i++) <div class="col-md-4 col-4">
                            <div class="card border border-dark">
                                <div class="card-header border-dark text-center p-2">
                                    <h3 class="font-weight-bold text-info mb-0">{{ $i }}</h3>
                                </div>
                                <div class="card-body border-dark p-1">
                                    <h6 class="text-center text-sm">
                                        <small>Nama</small><br>
                                        <small>Asal</small><br>
                                        <small><b>3%</b></small>
                                    </h6>
                                </div>
                            </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
</div><br>
</div>


<!-- Modal Edit -->
@foreach($challenge as $row)
<div class="modal fade border border-dark" id="modal-{{ $row->id_detail }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-{{ $row->id_detail }}" action="{{ route('challenge.participant.update', $row->id_detail) }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Nama</h6>
                            <h6>{{ $row->member->nama }}</h6>
                        </div>

                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Asal</h6>
                            <h6>{{ $row->member->uker ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</h6>
                        </div>
                    </div>

                    <label for="challenge">Pilihan Challenge</label>
                    <select id="challenge" name="challenge_id" class="form-control" required>
                        <option value="">-- Pilih Challenge --</option>
                        <option value="1" <?php echo (isset($row->challenge_id) && $row->challenge_id == 1) ? 'selected' : ''; ?>>Fat Loss</option>
                        <option value="2" <?php echo (isset($row->challenge_id) && $row->challenge_id == 2) ? 'selected' : ''; ?>>Muscle Gain</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, `{{ $row->id_detail }}`)">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Filter -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-sm">
            <div class="modal-header border-dark">
                <h5 class="modal-title font-weight-bold text-info text-md" id="filterLabel">
                    <i class="fas fa-filter"></i> Filter
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('challenge.participant.filter') }}" method="GET">
                @csrf
                <div class="modal-body">
                    <label class="text-sm mb-0">Pilih Instansi</label>
                    <select name="instansi" class="form-control form-control-sm border-dark" id="instansi">
                        <option value="">-- Seluruh Instansi --</option>
                        <option value="pusat" <?php echo $instansi == 'pusat' ? 'selected' : ''; ?>>Kemenkes</option>
                        <option value="upt" <?php echo $instansi == 'upt' ? 'selected' : ''; ?>>UPT</option>
                        <option value="umum" <?php echo $instansi == 'umum' ? 'selected' : ''; ?>>Mitra</option>
                    </select>

                    <div id="pusat" class="d-none">
                        <label class="small mt-2 mb-0">Pilih Unit Utama</label>
                        <select id="utamaSelect" name="utama" class="form-control form-control-sm border-dark">
                            <option value="">-- Seluruh Unit Utama --</option>
                            @foreach ($utama as $row)
                            <option value="{{ $row->id_unit_utama }}">
                                {{ $row->nama_unit_utama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <label class="small mt-2 mb-0">Pilih Gender</label>
                    <select name="gender" class="form-control form-control-sm border-dark" id="">
                        <option value="">-- Seluruh Gender --</option>
                        <option value="male" <?php echo $gender == 'male' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="female" <?php echo $gender == 'female' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" role="dialog" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-dark">
                <h5 class="modal-title font-weight-bold text-info text-md" id="filterLabel">
                    <i class="fas fa-users"></i> Tambah Peserta
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-peserta" action="{{ route('challenge.participant.store') }}" method="GET">
                @csrf
                <div class="modal-body">
                    <label class="text-sm mb-0">Peserta</label>
                    <select name="member" class="form-control form-control-sm border-dark member" style="width: 100%;">
                        <option value="">-- Pilih Peserta --</option>
                    </select>

                    <label class="small mt-2 mb-0">Challenge</label>
                    <select name="challenge_id" class="form-control form-control-sm border-dark">
                        <option value="">-- Pilih Challenge --</option>
                        <option value="1">FAT LOSS</option>
                        <option value="2">MUSCLE GAIN</option>

                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info btn-sm" onclick="confirmSubmit(event, 'peserta')">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    $('.member').select2({
        ajax: {
            url: '/member/json', // Ganti dengan URL endpoint yang benar
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder: 'Pilih Peserta',
        minimumInputLength: 1,
    });

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
                    columns: [0, 2, 3, 4]
                },
            }, {
                extend: 'excel',
                text: ' Excel',
                pageSize: 'A4',
                className: 'bg-success btn-sm rounded',
                title: 'fatloss',
                exportOptions: {
                    columns: [0, 2, 3, 4]
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
                    columns: [0, 2, 3, 4]
                },
            }, {
                extend: 'excel',
                text: ' Excel',
                pageSize: 'A4',
                className: 'bg-success btn-sm rounded',
                title: 'musclegain',
                exportOptions: {
                    columns: [0, 2, 3, 4]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#tMuscleGain_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(document).ready(function() {
        // Asal Instansi
        $('select[name="instansi"]').change(function() {
            var selectedValue = $(this).val()

            if (selectedValue === 'pusat') {
                $('#pusat').removeClass('d-none')
                $('#umum').addClass('d-none')
            } else if (selectedValue === 'umum') {
                $('#pusat').addClass('d-none')
                $('#umum').removeClass('d-none')
            } else if (selectedValue === 'upt') {
                $('#pusat').addClass('d-none')
                $('#umum').removeClass('d-none')
            } else {
                $('#pusat').addClass('d-none')
                $('#umum').addClass('d-none')
            }
        });
    })
</script>

<script>
    function confirmSubmit(event, id) {
        event.preventDefault();

        const form = document.getElementById('form-' + id);

        Swal.fire({
            title: "Loading...",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            willOpen: () => {
                Swal.showLoading();
            },
        })

        form.submit();
    }

    function confirmRemove(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus',
            text: 'Hapus Data',
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
