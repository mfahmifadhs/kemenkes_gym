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
                <div class="col-sm-9 col-8">
                    <h1 class="m-0 text-lg">Leaderboard Fat Loss & Muscle Gain Challenge</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('challenge') }}">Challenge</a></li>
                        <li class="breadcrumb-item active">Leaderboard</li>
                    </ol>
                </div>

                <div class="col-sm-3 col-4 text-right mt-2">
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
                <div class="row">
                    <div class="col-md-4 col-12 form-group">
                        <div class="bg-white rounded p-3 border border-dark table-responsive">
                            <label class="text-xs">Pemenang Challenge</label>
                            <table class="table table-striped text-center bg-white text-xs">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Peringkat</th>
                                        <th style="width: 20%;" class="text-left">Kategori</th>
                                        <th style="width: 50%;">Pemenang</th>
                                        <th style="width: 10%;">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($board as $row)
                                    <tr>
                                        <td><span class="text-info font-weight-bold">{{ $row->peringkat }}</span></td>
                                        <td class="text-left">
                                            {{ $row->kategori == 'male' ? 'Pria' : 'Wanita' }} {{ $row->challenge->nama_challenge }}
                                        </td>
                                        <td>
                                            @if (!$row->member)
                                            <a href="#" type="button" data-toggle="modal" data-target="#modal-{{ $row->id_leaderboard }}">
                                                <i class="fas fa-edit text-info"></i>
                                            </a>
                                            @else
                                            <span class="text-left">
                                                <a href="#" onclick="confirmRemove(event, `{{ route('challenge.leaderboard.delete', $row->id_leaderboard) }} `)">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </a>
                                                <b>{{ $row->member->nama }}</b> <br>
                                                <small class="ml-3">{{ $row->member->uker ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</small>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row->challenge_id == 1 && $row->nilai)
                                            <b>-{{ $row->nilai }}%</b>
                                            @elseif ($row->challenge_id == 2 && $row->nilai)
                                            <b>+{{ $row->nilai }}kg</b>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-8 col-12 form-group">
                        <div class="bg-white rounded p-3 border border-dark table-responsive" style="height: 100%;">
                            <label class="text-xs">Timbangan Peserta</label>
                            <table id="tTimbangan" class="table table-striped bg-white text-center text-xs">
                                <thead>
                                    <tr>
                                        <th style="width: 0%;">No</th>
                                        <th class="text-left">Nama</th>
                                        <th class="text-left" style="width: 10%;">Asal</th>
                                        <th>Fat</th>
                                        <th>Muscle Mass</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (collect($timbangan)->sortBy('nama') as $row)
                                    <tr>
                                        <td class="text-left">
                                            <a href="{{ route('challenge.participant.detail', $row['member_id']) }}">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-left">{{ strtoupper($row['nama']) }}</td>
                                        <td class="text-left">{{ strtoupper($row['uker']) }}</td>
                                        <td>{{ $row['fatp_diff'] }} %</td>
                                        <td>{{ $row['fatm_diff'] }} kg</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>


<!-- Modal Edit -->
@foreach($board as $row)
<div class="modal fade border border-dark" id="modal-{{ $row->id_leaderboard }}" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-{{ $row->id_leaderboard }}" action="{{ route('challenge.leaderboard.update', $row->id_leaderboard) }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title text-info font-weight-bold"><i class="fas fa-user"></i> Update Pemenang</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <label style="width: 20%;">Challenge</label>
                        <label style="width: 80%;">: {{ $row->challenge->nama_challenge }}</label>
                    </div>
                    <div class="input-group">
                        <label style="width: 20%;">Kategori</label>
                        <label style="width: 80%;">: {{ $row->kategori == 'male' ? 'Pria' : 'Wanita' }}</label>
                    </div>
                    <div class="input-group">
                        <label style="width: 20%;">Peringkat</label>
                        <label style="width: 80%;">: {{ $row->peringkat }}</label>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="small">Pilih Pemenang</label>
                        <select name="member_id" class="form-control peserta" style="width: 100%;" required>
                            <option value="">-- Pilih Pemenang --</option>
                            @foreach ($peserta->sortBy('member.nama') as $subRow)
                            <option value="{{ $subRow->member_id }}">
                                {{ strtoupper($subRow->member->nama) }} -
                                {{ strtoupper($subRow->member->uker ? $subRow->member->uker->nama_unit_kerja : $subRow->member->nama_instansi) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="small">Nilai</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control number" name="nilai" required>
                            <div class="input-group-append">
                                @if ($row->challenge_id == 1)
                                <span class="input-group-text border-dark">%</span>
                                @else
                                <span class="input-group-text border-dark">KG</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, `{{ $row->id_leaderboard }}`)">Simpan</button>
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
            <form action="{{ route('challenge.leaderboard.filter') }}" method="GET">
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

                    <label class="small mt-2 mb-0">Pilih Challenge</label>
                    <select name="challenge" class="form-control form-control-sm border-dark">
                        <option value="">-- Seluruh Challenge --</option>
                        @foreach ($challenge as $row)
                        <option value="{{ $row->id_challenge }}" <?php echo $pickChall == $row->id_challenge ? 'selected' : ''; ?>>
                            {{ $row->nama_challenge }}
                        </option>
                        @endforeach
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

        $("#tTimbangan").DataTable({
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
    $('.peserta').select2()
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
