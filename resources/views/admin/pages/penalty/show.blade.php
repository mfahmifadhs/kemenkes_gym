@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header col-md-10 mx-auto">
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

    <div class="content col-md-10 mx-auto">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <label class="card-title"><i class="fas fa-calendar-times"></i> Tabel Penalty</label>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="form-absen" action="{{ route('absen.filter') }}" method="GET">
                            <table id="tpenalty" class="table table-bordered small text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Kelas</th>
                                        <th>Tanggal Ketidakhadiran</th>
                                        <th>Nama Lengkap</th>
                                        <th>Unit Kerja/UPT/Instansi</th>
                                        <th>Waktu Penalty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penalty as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('member.detail', $row->user_id) }}"><i class="fas fa-eye"></i></a>
                                            @if (Auth::user()->role_id == 1)
                                            <a href="" onclick="confirmRemove(event, `{{ route('penalty.delete', $row->id_penalty) }}`)">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{ $row->jadwal?->kelas->nama_kelas }}</td>
                                        <td>{{ $row->jadwal?->tanggal_kelas }}</td>
                                        <td>{{ $row->member->nama }}</td>
                                        <td>{{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                        <td>{{ Carbon\Carbon::parse($row->tgl_awal_penalty)->isoFormat('DD MMM Y').' s/d '. Carbon\Carbon::parse($row->tgl_akhir_penalty)->isoFormat('DD MMM Y') }}</td>
                                    </tr>
                                    @endforeach

                                    @if ($penalty->count() == 0)
                                    <tr>
                                        <td colspan="8">Data not available</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>

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

    $("#tpenalty").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": true,
        "paging": true,
        "searching": true,
        buttons: [{
            extend: 'pdf',
            text: ' Print PDF',
            pageSize: 'A4',
            className: 'bg-danger',
            title: 'Daftar Penalty',
            exportOptions: {
                columns: [4, 5, 2, 3, 6]
            },
        }],
        "bDestroy": true
    }).buttons().container().appendTo('#tpenalty_wrapper .col-md-6:eq(0)');
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
