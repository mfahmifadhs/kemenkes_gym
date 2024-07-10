@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-8">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal {{ ucwords(strtolower($jadwal->kelas->nama_kelas)) }}</small></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jadwal.pilih', Carbon\Carbon::parse($jadwal->tanggal_kelas)->format('d-M-Y')) }}">Jadwal</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('kelas.detail', $jadwal->kelas_id) }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="text-center p-2">
                                <img src="{{ asset('dist/img/class/'. $jadwal->kelas->img_icon) }}" class="text-primary w-50 img-circle">
                            </h3>
                        </div>
                        <div class="col-md-8">
                            <label class="text-secondary text-sm mb-0">
                                <a href="{{ route('kelas.edit', $jadwal->kelas->id_kelas) }}"><i class="fas fa-edit"></i></a>
                                <i>Informasi Kelas</i>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Nama</label>
                                    <h6 class="text-sm">{{ $jadwal->kelas->nama_kelas }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0 text-sm">Status</label>
                                    <h6 class="text-sm">{{ $jadwal->kelas->status }}</h6>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <label class="mb-0 text-sm">Deskripsi</label>
                                    <h6 class="text-sm text-capitalize mb-0">{{ $jadwal->kelas->deskripsi }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <span class="text-sm">{{ Carbon\Carbon::parse($jadwal->tanggal_kelas)->isoFormat('dddd, DD MMMM Y') }}</span>
                        <h6 class="text-xs">Pukul {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->isoFormat('HH.mm').' s/d '.Carbon\Carbon::parse($jadwal->waktu_mulai)->isoFormat('HH.mm') }}</h6>
                    </div>

                    <div class="float-right mt-2">
                        {{ $jadwal->peserta->where('tanggal_latihan', $jadwal->tanggal_kelas)->count() }} / {{ $jadwal->kuota }}
                    </div>
                </div>
                <div class="card-header">
                    <label class="card-title text-sm mt-1">
                        <i class="fas fa-users text-success"></i> Peserta
                    </label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-peserta" class="table table-bordered text-xs text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Kehadiran</th>
                                    <th>Nama</th>
                                    <th>NIP/NIK</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Unit Kerja/UPT/Umum</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal->peserta->sortBy(function($row) {
                                return $row->member->nama;
                                }) as $row)
                                <tr>
                                    <td style="width: 0vh;">{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('member.detail', $row->member_id) }}"><i class="fas fa-eye"></i></a>
                                        @if (Auth::user()->role_id != 4)
                                        <a href="" data-toggle="modal" data-target="#modal-{{ $row->id_peserta }}">
                                            <i class="fas fa-pencil mx-2"></i>
                                        </a>
                                        <a href="" onclick="confirmRemove(event, `{{ route('join.delete', $row->id_peserta) }}`)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->kehadiran == 'hadir')
                                        <span class="badge badge-success">Hadir</span>
                                        @elseif ($row->kehadiran == 'alpha')
                                        <span class="badge badge-danger">Tidak Hadir</span>
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $loop->iteration }}. {{ ucwords(strtolower($row->member->nama)) }}</td>
                                    <td>{{ $row->member->nip_nik }}</td>
                                    <td>{{ $row->member->tanggal_lahir }}</td>
                                    <td class="text-left">{{ $row->member->instansi == 'pusat' ? $row->member->uker?->nama_unit_kerja : $row->member->nama_instansi }}</td>

                                    <td>{{ $row->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><br>
        </div>
    </div>
</div>


@foreach ($jadwal->peserta as $row)
<div class="modal fade" id="modal-{{ $row->id_peserta }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kehadiran.update', $row->id_peserta) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <label class="col-md-3">Kelas</label>
                        <div class="col-md-9">: {{ $row->jadwal->kelas->nama_kelas }} | {{ \Carbon\carbon::parse($row->jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\carbon::parse($row->jadwal->waktu_selesai)->format('H:i') }}</div>
                        <label class="col-md-3">Nama</label>
                        <div class="col-md-9">: {{ $row->member->nama }}</div>
                        <label class="col-md-3">Asal Instansi</label>
                        <div class="col-md-9">: {{ $row->member->instansi == 'pusat' ? $row->member->uker->nama_unit_kerja : $row->member->nama_instansi }}</div>
                        <label class="col-md-3">Kehadiran</label>
                        <div class="col-md-9">:
                            <label class="radio-inline">
                                <input type="radio" id="true" name="kehadiran" value="hadir" <?php echo ($row->kehadiran == 'hadir') ? 'checked' : ''; ?>>
                                <span class="small">Hadir</span>
                            </label>
                            <label class="radio-inline ml-2">
                                <input type="radio" id="false" name="kehadiran" value="alpha" <?php echo ($row->kehadiran == 'alpha') ? 'checked' : ''; ?>>
                                <span class="small">Tidak Hadir</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@section('js')
<script>
    $(function() {
        $("#table-peserta").DataTable({
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
                title: 'Kehadiran',
                exportOptions: {
                    columns: [3, 4, 5, 6]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#table-peserta_wrapper .col-md-6:eq(0)');

        $("#table-history").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": false,
            "paging": false,
            "searching": false
        })
    })

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
</script>
@endsection
@endsection
