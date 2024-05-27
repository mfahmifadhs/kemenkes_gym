<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Member</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/admin/css/adminlte.css') }}">
    <style>
        @media print {
            .pagebreak {
                page-break-after: always;
            }

            .table-data {
                border: 1px solid;
                font-size: 20px;
                vertical-align: middle;
            }

            .table-data th,
            .table-data td {
                border: 1px solid;
                vertical-align: middle;
            }

            .table-data thead th,
            .table-data thead td {
                border: 1px solid;
                vertical-align: middle;
            }
        }

        .divTable {
            border-top: 1px solid;
            border-left: 1px solid;
            border-right: 1px solid;
            font-size: 21px;
        }

        .divThead {
            border-bottom: 1px solid;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container" style="font-size: 20px;">
        <p class="text-center">
            <img src="{{ asset('dist/img/logo.png') }}" class="img-fluid w-50">
        </p>
        <div class="float-left">
            <div class="text-uppercase h2 font-weight-bold text-info">
                <p>Daftar Member</p>
            </div>
        </div>
        <div class="float-right">
            {{ \Carbon\carbon::now()->isoFormat('HH:mm') }} |
            {{ \Carbon\carbon::now()->isoFormat('DD MMMM Y') }}
        </div>
        <div class="table-responsive mt-5">
            <table class="table table-data text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Informasi Peserta</th>
                        <th style="width: 20%;">Peminatan</th>
                        <th style="width: 20%;">Target</th>
                    </tr>
                </thead>
                @foreach($member as $row)
                <thead style="font-size: 18px">
                    <tr>
                        <td>{{ $loop->iteration }}</tdass=>
                        <td class="text-left">
                            <div class="row">
                                <div class="col-md-3 col-3">Nama</div>
                                <div class="col-md-9 col-9">: {{ $row->nama }}</div>
                                <div class="col-md-3 col-3">NIP/NIK</div>
                                <div class="col-md-9 col-9">: {{ $row->nip_nik }}</div>
                                <div class="col-md-3 col-3">Asal</div>
                                <div class="col-md-9 col-9 text-capitalize">: {{ $row->instansi }}</div>
                                <div class="col-md-3 col-3">Instansi</div>
                                <div class="col-md-9 col-9">:
                                    {{ $row->instansi == 'pusat' ? $row->uker->nama_unit_kerja : $row->nama_instansi }}
                                </div>
                                <div class="col-md-3 col-3">Jenis Kelamin</div>
                                <div class="col-md-9 col-9">: {{ $row->jenis_kelamin == 'male' ? 'Pria' : 'Wanita' }}</div>
                                <div class="col-md-3 col-3">Email</div>
                                <div class="col-md-9 col-9">: {{ $row->email}}</div>
                                <div class="col-md-3 col-3">No. Telp</div>
                                <div class="col-md-9 col-9">: {{ $row->no_telp}}</div>
                            </div>
                        </td>
                        <td class="text-left">
                            @foreach($row->minatKelas as $subRow)
                            {{ $loop->iteration }}. {{ ucwords(strtolower($subRow->kelas?->nama_kelas)) }} <br>
                            @endforeach
                        </td>
                        <td class="text-left">
                            @foreach($row->minatTarget as $subRow)
                            {{ $loop->iteration }}. {{ ucwords(strtolower($subRow->target?->nama_target)) }} <br>
                            @endforeach
                        </td>
                    </tr>
                </thead>
                @endforeach
            </table>
        </div>
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
