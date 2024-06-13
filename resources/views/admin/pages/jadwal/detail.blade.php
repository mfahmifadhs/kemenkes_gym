@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-6">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal {{ $jadwal->kelas->nama_kelas }}</small></h1>
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
        <div class="container-fluid col-md-6">
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
                        <table id="table-history" class="table table-bordered text-xs text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Unit Kerja/UPT/Umum</th>
                                    <th>Nama</th>
                                    <th>Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal->peserta as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if (Auth::user()->role_id == 1)
                                        <a href="{{ route('member.detail', $row->member_id) }}"><i class="fas fa-eye"></i></a>
                                        <a href="" onclick="confirmRemove(event, `{{ route('join.delete', $row->id_peserta) }}`)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $row->member->instansi == 'pusat' ? $row->member->uker?->nama_unit_kerja : $row->member->nama_instansi }}</td>
                                    <td class="text-left">{{ $row->member->nama }}</td>
                                    <td>{{ $row->kehadiran }}</td>
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

@section('js')
<script>
    $(function() {
        $("#table-active").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": false,
            "paging": false,
            "searching": false
        })

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
