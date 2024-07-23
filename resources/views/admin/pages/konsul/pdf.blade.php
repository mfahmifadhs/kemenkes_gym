<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table .td-1 {
            width: 30%;
        }

        table .td-2 {
            width: 5%;
        }

        table .td-3 {
            width: 65%;
        }
    </style>
</head>

<body style="font-size: Calibri;">
    <img src="https://i.ibb.co.com/RyChbtY/logo-light-11zon-1.png" width="200">
    <table class="table" style="width: 100%;">
        <tr>
            <td colspan="3">
                <h4><b>Hasil Konsultasi</b></h4>
            </td>
        </tr>
        <tr>
            <td colspan="3">{{ $konsul->created_at }}</td>
        </tr>
        <tr>
            <td class="td-1">Kode Book</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->kode_book }}</td>
        </tr>
        <tr>
            <td class="td-1">Member ID</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->member->member_id }}</td>
        </tr>
        <tr>
            <td class="td-1">Nama Pasien</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->member->nama }}</td>
        </tr>
        <tr>
            <td class="td-1">Asal</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->member->instansi == 'pusat' ? $konsul->member->uker->nama_unit_kerja : $konsul->member->nama_instansi }}</td>
        </tr>
        <tr>
            <td class="td-1">Tanggal Lahir</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->member->tanggal_lahir }}</td>
        </tr>
        <tr>
            <td class="td-1">Usia</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->member->usia }}</td>
        </tr>
    </table>

    <table class="table" style="width: 100%; margin-top: 20px;">
        <tr>
            <td class="td-1">Nama Dokter</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->dokter->nama_dokter }}</td>
        </tr>
        <tr>
            <td class="td-1">Spesialisasi</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->dokter->spesialisasi }}</td>
        </tr>
        <tr>
            <td class="td-1">Tanggal Konsul</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $konsul->tanggal_konsul }}</td>
        </tr>
        <tr>
            <td class="td-1">Waktu Konsul</td>
            <td class="td-2">:</td>
            <td class="td-3">
                @if ($konsul->waktu_konsul == 1) 07.00 WIB s/d 07.20 WIB @endif
                @if ($konsul->waktu_konsul == 2) 07.20 WIB s/d 08.40 WIB @endif
                @if ($konsul->waktu_konsul == 3) 07.40 WIB s/d 08.00 WIB @endif
                @if ($konsul->waktu_konsul == 4) 08.00 WIB s/d 08.20 WIB @endif
                @if ($konsul->waktu_konsul == 5) 08.20 WIB s/d 08.40 WIB @endif
                @if ($konsul->waktu_konsul == 6) 08.40 WIB s/d 09.00 WIB @endif
            </td>
        </tr>
        <tr>
            <td class="td-1">Lokasi</td>
            <td class="td-2">:</td>
            <td class="td-3">Ruang Dokter, Kemenkes Bootcamp & Fitness Center</td>
        </tr>
        <tr>
            <td class="td-1" style="vertical-align: top;">Catatan Dokter</td>
            <td class="td-2" style="vertical-align: top;">:</td>
            <td class="td-3">{!! nl2br($konsul->catatan_pasien) !!}</td>
        </tr>
    </table>
</body>

</html>
