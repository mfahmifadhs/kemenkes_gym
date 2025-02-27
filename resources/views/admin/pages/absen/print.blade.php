<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kehadiran Member</title>

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
                <p>Daftar Kehadiran Member</p>
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
                        <th style="width: 20%;">Tanggal</th>
                        <th>Member</th>
                        <th style="width: 20%;">Kehadiran</th>
                    </tr>
                </thead>
                @foreach($absen as $row)
                <thead style="font-size: 18px">
                    <tr>
                        <td>{{ $loop->iteration }}</tdass=>
                        <td>{{ $row->tanggal }}</td>
                        <td class="text-left align-top">
                            <div class="row">
                                <div class="col-4">Nama</div>
                                <div class="col-7">: {{ $row->member->nama }}</div>
                                <div class="col-4">Unit Kerja</div>
                                <div class="col-7">: {{ $row->member->uker?->nama_unit_kerja }}</div>
                            </div>
                        </td>
                        <td class="text-left align-top">
                            <div class="row">
                                <div class="col-4">Masuk</div>
                                <div class="col-8">: {{ $row->waktu_masuk }}</div>
                                <div class="col-4">Keluar</div>
                                <div class="col-8">: {{ $row->waktu_keluar }}</div>
                            </div>
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
