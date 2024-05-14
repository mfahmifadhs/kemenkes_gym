@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-lg">Absensi</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Absensi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <label class="card-title"><i class="fas fa-users"></i> Tabel Absensi</label>

                    <div class="card-tools">
                        <a id="downloadButton" onclick="downloadFile('pdf')" class="btn btn-csv bg-danger border-danger" target="__blank">
                            <span class="btn btn-danger btn-sm"><i class="fas fa-print"></i></span>
                            <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                            <small>PRINT</small>
                        </a>
                        <a id="downloadButton" onclick="downloadFile('excel')" class="btn btn-csv bg-success border-success" target="__blank">
                            <span class="btn btn-success btn-sm"><i class="fas fa-download"></i></span>
                            <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                            <small>XLSX</small>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="form-absen" action="{{ route('absen.filter') }}" method="GET">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="align-left">
                                    <div class="sort-container">
                                        <div class="input-group">
                                            <select name="perPage" class="form-control form-control-sm border-dark rounded mt-2 w-auto" id="perPage" onchange="this.form.submit()">
                                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                            </select>

                                            <select name="utama" class="form-control form-control-sm border-dark rounded mx-2 mt-2 w-auto" onchange="this.form.submit()">
                                                <option value="">seluruh unit utama</option>
                                                @foreach($utama as $row)
                                                <option value="{{ $row->id_unit_utama }}" <?php echo $colUtama == $row->id_unit_utama ? 'selected' : '' ?>>
                                                    {{ $row->nama_unit_utama }}
                                                </option>
                                                @endforeach
                                            </select>

                                            <select name="uker" class="form-control form-control-sm border-dark rounded ml-0 mt-2 w-auto" onchange="this.form.submit()">
                                                <option value="">seluruh unit kerja</option>
                                                @foreach($uker as $row)
                                                <option value="{{ $row->id_unit_kerja }}" <?php echo $colUker == $row->id_unit_kerja ? 'selected' : '' ?>>
                                                    {{ $row->nama_unit_kerja }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-right">
                                    <div class="sort-container">
                                        <div class="input-group">
                                            <select name="tanggal" class="form-control form-control-sm border-dark rounded ml-1 mt-2 w-auto text-center" onchange="this.form.submit()">
                                                <option value="">seluruh tanggal</option>
                                                @foreach(range(1, 31) as $dateNumber)
                                                @php $rowTgl = Carbon\Carbon::create()->day($dateNumber)->isoFormat('DD'); @endphp
                                                <option value="{{ $rowTgl }}" <?php echo $colDate == $rowTgl ? 'selected' : '' ?>>
                                                    {{ $rowTgl }}
                                                </option>
                                                @endforeach
                                            </select>

                                            <select name="bulan" class="form-control form-control-sm border-dark rounded ml-2 mt-1 w-auto text-center" onchange="this.form.submit()">
                                                <option value="">seluruh bulan</option>
                                                @foreach(range(1, 12) as $monthNumber)
                                                @php $rowBulan = Carbon\Carbon::create()->month($monthNumber); @endphp
                                                <option value="{{ $rowBulan->isoFormat('MM') }}" <?php echo $colMonth == $rowBulan->isoFormat('M') ? 'selected' : '' ?>>
                                                    {{ $rowBulan->isoFormat('MMMM') }}
                                                </option>
                                                @endforeach
                                            </select>

                                            <select name="tahun" class="form-control form-control-sm border-dark rounded ml-2 mt-1 w-auto text-center" onchange="this.form.submit()">
                                                <option value="">seluruh tahun</option>
                                                @foreach(range(2024, 2030) as $yearNumber)
                                                @php $rowTahun = Carbon\Carbon::create()->year($yearNumber); @endphp
                                                <option value="{{ $rowTahun->isoFormat('Y') }}" <?php echo $colYear == $rowTahun->isoFormat('Y') ? 'selected' : '' ?>>
                                                    {{ $rowTahun->isoFormat('Y') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered small text-center">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>AKSI</th>
                                        <th>TANGGAL</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>UNIT KERJA/UPT/INSTANSI</th>
                                        <th>WAKTU DATANG</th>
                                        <th>WAKTU KELUAR</th>
                                        <th>DURASI LATIHAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absen as $row)
                                    <tr>
                                        <td>{{ $absen->firstItem() + $loop->index }}</td>
                                        <td>
                                            <a type="button" class="mx-2" data-toggle="modal" data-target="#edit-{{ $row->id_absen }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="" onclick="confirmRemove(event, `{{ route('absen.delete', $row->id_absensi) }}`)">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td>{{ $row->tanggal }}</td>
                                        <td class="text-left">{{ $row->member->nama }}</td>
                                        <td class="text-left">{{ $row->member->uker->nama_unit_kerja }}</td>
                                        <td>{{ $row->waktu_masuk }}</td>
                                        <td>{{ $row->waktu_keluar }}</td>
                                        <td>
                                            <?php
                                            $waktu_masuk = new DateTime($row->waktu_masuk);
                                            $waktu_keluar = new DateTime($row->waktu_keluar);

                                            $selisih = $waktu_masuk->diff($waktu_keluar);

                                            echo $selisih->format('%h jam %i menit');
                                            ?>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if ($absen->count() == 0)
                                    <tr>
                                        <td colspan="8">Data not available</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    Total: {{ number_format($absen->total(), 0, ',', '.') }}
                                    Current page: {{ $absen->count()}}

                                    <div class="mt-2">{{ $absen->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>

<!-- Modal edit -->
@foreach ($absen as $row)
<div class="modal fade" id="edit-{{ $row->id_absen }}" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('absen.update', $row->id_absensi) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row form-group">
                        <label class="col-form-label col-md-3">Tanggal</label>
                        <input type="text" class="form-control col-md-9" value="{{ $row->tanggal }}" readonly>
                    </div>
                    <div class="row form-group">
                        <label class="col-form-label col-md-3">Nama</label>
                        <input type="text" class="form-control col-md-9" value="{{ $row->member->nama }}" readonly>
                    </div>
                    <div class="row form-group">
                        <label class="col-form-label col-md-3">Unit Kerja</label>
                        <input type="text" class="form-control col-md-9" value="{{ $row->member->uker->nama_unit_kerja }}" readonly>
                    </div>
                    <div class="row form-group">
                        <label class="col-form-label col-md-3">Waktu Datang</label>
                        <input type="time" class="form-control col-md-9" name="masuk" value="{{ $row->waktu_masuk }}">
                    </div>
                    <div class="row form-group">
                        <label class="col-form-label col-md-3">Waktu Keluar</label>
                        <input type="time" class="form-control col-md-9" name="keluar" value="{{ $row->waktu_keluar }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="confirm(event)">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@section('js')
<script>
    $(document).ready(function() {
        // Handle click event on clear button
        $(".clearSearch").on("click", function() {
            var form = $(this).closest('form');
            var inputField = form.find('input[type="search"]');
            console.log(inputField)
            inputField.val('');
            form.submit();
        });
    });
</script>

<script>
    function confirm(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: "Proses...",
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
            title: 'Delete ?',
            text: 'Delete this data',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function downloadFile(downloadFile) {
        var form = document.getElementById('form-absen');
        var downloadButton = document.getElementById('downloadButton');
        var downloadSpinner = document.getElementById('downloadSpinner');

        downloadSpinner.style.display = 'inline-block';

        var existingDownloadFile = form.querySelector('[name="downloadFile"]');
        if (existingDownloadFile) {
            existingDownloadFile.remove();
        }

        var downloadFileInput = document.createElement('input');
        downloadFileInput.type = 'hidden';
        downloadFileInput.name = 'downloadFile';
        downloadFileInput.value = downloadFile;
        form.appendChild(downloadFileInput);

        downloadButton.disabled = true;
        form.target = '_blank';

        form.submit();
        location.reload();
    }
</script>
@endsection
@endsection
