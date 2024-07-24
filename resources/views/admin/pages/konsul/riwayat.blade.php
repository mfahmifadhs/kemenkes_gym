@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-8">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"> Konsultasi</small></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('konsul') }}">Konsultasi</a></li>
                        <li class="breadcrumb-item active">Riwayat</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border border-dark">
                        <div class="card-header border-dark">
                            <label class="card-title text-sm mt-1"><i>Progres Kebugaran</i></label>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-dark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="text-sm">
                                <b>A. Test VO2Max</b>
                                <ol>
                                    @foreach ($konsul as $i => $row)
                                    <li>
                                        {{ str_replace('.', ' menit ', $row->hasil_sipgar) }} detik -

                                        @if ($row->kategori_sipgar == 'sangatbaik' || $row->kategori_sipgar == 'baik')
                                        <span class="badge badge-success">{{ str_replace(['sangatbaik'], ['sangat baik'], $row->kategori_sipgar) }}</span>
                                        @elseif ($row->kategori_sipgar == 'sangatkurang' || $row->kategori_sipgar == 'kurang')
                                        <span class="badge badge-danger">{{ str_replace(['kurangbaik'], ['sangat kurang'], $row->kategori_sipgar) }}</span>
                                        @else
                                        <span class="badge badge-warning">{{ $row->kategori_sipgar }}</span>
                                        @endif
                                    </li>
                                    @endforeach
                                </ol>

                                <b>B. Test Fitness</b>
                                <li class="ml-2">
                                    Back & Stretch
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ $row->hasil_backs }} cm -

                                            @if ($row->kategori_backs == 'baik')<span class="badge badge-success"> Baik</span>@endif
                                            @if ($row->kategori_backs == 'cukup')<span class="badge badge-warning"> Cukup</span>@endif
                                            @if ($row->kategori_backs == 'kurang')<span class="badge badge-danger"> Kurang</span>@endif
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                                <li class="ml-2">
                                    Handgrip Dynamometer (Kiri)
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ $row->hasil_dynamo_r }} kg -

                                            @if ($row->kategori_dynamo_r == 'baik')<span class="badge badge-success"> Baik</span>@endif
                                            @if ($row->kategori_dynamo_r == 'cukup')<span class="badge badge-warning"> Cukup</span>@endif
                                            @if ($row->kategori_dynamo_r == 'kurang')<span class="badge badge-danger"> Kurang</span>@endif
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                                <li class="ml-2">
                                    Handgrip Dynamometer (Kanan)
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ $row->hasil_dynamo_l }} kg -

                                            @if ($row->kategori_dynamo_l == 'baik')<span class="badge badge-success"> Baik</span>@endif
                                            @if ($row->kategori_dynamo_l == 'cukup')<span class="badge badge-warning"> Cukup</span>@endif
                                            @if ($row->kategori_dynamo_l == 'kurang')<span class="badge badge-danger"> Kurang</span>@endif
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                                <li class="ml-2">
                                    Plank
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ str_replace('.', ' menit ', $row->hasil_plank) }} detik
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                                <li class="ml-2">
                                    Sit Up
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ $row->hasil_situp }}x -

                                            @if ($row->kategori_situp == 'baik')<span class="badge badge-success"> Baik</span>@endif
                                            @if ($row->kategori_situp == 'cukup')<span class="badge badge-warning"> Cukup</span>@endif
                                            @if ($row->kategori_situp == 'kurang')<span class="badge badge-danger"> Kurang</span>@endif
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                                <li class="ml-2">
                                    Lingkar Perut
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ $row->hasil_lingperut }} cm
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                                <li class="ml-2">
                                    Tekanan Darah
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ $row->hasil_tekdarah }} mmHg
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                                <li class="ml-2">
                                    Denyut Nadi
                                    <ol>
                                        @foreach ($konsul as $i => $row)
                                        <li>
                                            {{ $row->hasil_nadi }} kali/menit
                                        </li>
                                        @endforeach
                                    </ol>
                                </li>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card border border-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4 my-auto">
                                    <h3 class="text-center p-2">
                                        <i class="fas fa-user-circle fa-3x"></i>
                                    </h3>
                                </div>
                                <div class="col-md-8">
                                    <label class="text-secondary text-sm mb-0">
                                        <i>Riwayat Konsultasi</i>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="mb-0 text-sm">Nama Pegawai</label>
                                            <h6 class="text-sm">{{ $member->nama }}</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mb-0 text-sm">Asal</label>
                                            <h6 class="text-sm">{{ $member->instansi == 'pusat' ? $member->uker->nama_unit_kerja : $member->nama_instansi }}</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mb-0 text-sm">Jenis Kelamin</label>
                                            <h6 class="text-sm">{{ $member->jenis_kelamin == 'male' ? 'Laki-laki' : 'Perempuan' }}</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mb-0 text-sm">No. HP</label>
                                            <h6 class="text-sm">{{ $member->no_telp }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                @foreach ($konsul as $row)
                                <div class="col-md-12">
                                    <div class="card border border-dark">
                                        <div class="card-header border-dark">
                                            <label class="card-title text-sm mt-2">Konsultasi {{ $loop->iteration }}</label>
                                            <div class="card-tools">
                                                <label class="card-title text-xs text-right">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ Carbon\Carbon::parse($row->tanggal_konsul)->isoFormat('DD MMMM Y') }}
                                                    <br>
                                                    <i class="fas fa-clock"></i>
                                                    @if ($row->waktu_konsul == 1) 07.00 WIB s/d 07.20 WIB @endif
                                                    @if ($row->waktu_konsul == 2) 07.20 WIB s/d 08.40 WIB @endif
                                                    @if ($row->waktu_konsul == 3) 07.40 WIB s/d 08.00 WIB @endif
                                                    @if ($row->waktu_konsul == 4) 08.00 WIB s/d 08.20 WIB @endif
                                                    @if ($row->waktu_konsul == 5) 08.20 WIB s/d 08.40 WIB @endif
                                                    @if ($row->waktu_konsul == 6) 08.40 WIB s/d 09.00 WIB @endif
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <label class="text-sm">Catatan Dokter</label>
                                            <h6 class="text-sm">
                                                @if ($row->catatan_dokter) Tidak ada catatan @endif
                                                {!! nl2br($row->catatan_dokter) !!}
                                            </h6>
                                            <hr>
                                            <label class="text-sm">Catatan Pasien</label>
                                            <h6 class="text-sm">{!! nl2br($row->catatan_pasien) !!}</h6>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
            "autoWidth": false,
            "info": true,
            "paging": true,
            "searching": true,
            buttons: [{
                extend: 'pdf',
                text: ' PDF',
                pageSize: 'A4',
                className: 'bg-danger',
                title: 'Riwayat Pasien',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                },
            }, {
                extend: 'excel',
                text: ' Excel',
                className: 'bg-success',
                title: 'Riwayat Pasien',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                },
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#table-history_wrapper .col-md-6:eq(0)');
    })

    function confirmRemove(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus ?',
            text: 'Hapus peserta peminatan',
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
