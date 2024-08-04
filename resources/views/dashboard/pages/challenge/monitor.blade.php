<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Challenge</title>

    <style>
        table .td-1 {
            width: 20%;
        }

        table .td-2 {
            width: 3%;
        }

        table .td-3 {
            width: 65%;
        }
    </style>
</head>

<body style="font-size: Arial;">
    <center><img src="https://i.ibb.co.com/RyChbtY/logo-light-11zon-1.png" width="200"></center>
    <table class="table" style="width: 100%;">
        <tr>
            <td colspan="3">
                <h3><b>
                        <center>
                            LEMBAR MONITORING <br>
                            HASIL PENGUKURAN BERAT BADAN / MASSA OTOT
                        </center>
                    </b></h3>
            </td>
        </tr>
        <tr>
            <td colspan="3">Saya yang bertandatangan dibawah ini:</td>
        </tr>
        <tr>
            <td class="td-1">Nama</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $detail->member->nama }}</td>
        </tr>
        <tr>
            <td class="td-1">NIP/NIK</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $detail->member->nip_nik }}</td>
        </tr>
        <tr>
            <td class="td-1">ID Member</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $detail->member->member_id }}</td>
        </tr>
        <tr>
            <td class="td-1">Jenis Kelamin</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $detail->member->jenis_kelamin == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="td-1">Asal Instansi</td>
            <td class="td-2">:</td>
            <td class="td-3">
                {{ $detail->member->instansi == 'pusat' ? 'Kantor Pusat' : ($detail->member->instansi == 'upt' ? 'UPT' : 'Mitra') }}
            </td>
        </tr>
        <tr>
            <td class="td-1">Nama Instansi</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $detail->member->uker ? $detail->member->uker->nama_unit_kerja : $detail->member->nama_instansi }}</td>
        </tr>
        <tr>
            <td class="td-1">Nomor Handphone</td>
            <td class="td-2">:</td>
            <td class="td-3">{{ $detail->member->no_hp }}</td>
        </tr>
        <tr>
            <td class="td-1">Pilihan Challenge</td>
            <td class="td-2">:</td>
            <td class="td-3"><i>{{ $detail->challenge->nama_challenge }}</i></td>
        </tr>
    </table>

    <table border="1" class="table table-bordered" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr class="text-center">
                <th>Nomor</th>
                <th>
                    <div style="width: 70%;">Tanggal Pengukuran
                    (dd-mm-yyyy)
                    </div>
                </th>
                <th>Nilai Pengukuran (kg/%)</th>
                <th>Keterngan</th>
                <th>Tanda Tangan Peserta</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i <= 5; $i++)
            <tr>
                <td style="height: 5%;">
                    <center>{{ $i+1 }}</center>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    <table class="mt-3">
        <tr>
            <td colspan="3" style="text-align: justify;">
                Dengan ini menyatakan data diatas adalah benar dan sesuai untuk digunakan sebagai
                komponen penilaian <i>Fat Loss and Muscle Gain Challenge</i> Kemenkes Bootcamp & Fitness Center
            </td>
        </tr>
    </table>

    <table border="1" class="table table-bordered border-dark" style="width: 100%; margin-top: 20px;">
        <tr>
            <td>
                <div style="height: 10%;"></div>
            </td>
            <td>
                <div style="height: 10%;"></div>
            </td>
        </tr>
        <tr>
            <td>Foto Diri Pengukuran Awal</td>
            <td>Foto Diri Pengukuran Akhir</td>
        </tr>
    </table>
</body>

</html>
