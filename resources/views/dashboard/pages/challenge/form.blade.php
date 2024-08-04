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
                            FORMULIR PERSETUJUAN PESERTA <br>
                            <i>Fat Loss and Muscle Gain Challenge</i> <br>
                            Kemenkes Bootcamp & Fitness Center
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
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: justify;">
                Dengan ini menyetujui untuk mendaftarkan diri sebagai peserta Fat Loss and Muscle
                Gain Challenge Kemenkes Bootcamp & Fitness Center serta menyetujui dan menerima syarat
                dan ketentuan yang diberlakukan dalam challenge ini. Adapun syarat dan ketentuan seperti di bawah ini:
            </td>
        </tr>
    </table>

    <table class="table table-bordered" style="width: 100%; margin-top: 30px;">
        <tr>
            <td colspan="3">
                <b>Syarat dan Ketentuan:</b>
            </td>
        </tr>
        <tr>
            <td style="width: 5px; vertical-align: top;">1.</td>
            <td colspan="2">Peserta merupakan pegawai Kantor Pusat/ Unit Pelaksana Teknis/ Mitra Kementerian Kesehatan RI;</td>
        </tr>
        <tr>
            <td style="width: 5px; vertical-align: top;">2.</td>
            <td colspan="2">Peserta bersedia untuk melakukan foto full body pada saat pendaftaran dan pengukuran di akhir challenge;</td>
        </tr>
        <tr>
            <td style="width: 5px; vertical-align: top;">3.</td>
            <td colspan="2">Peserta menyetujui dan memberikan izin sepenuhnya dalam penggunaan foto diri untuk kepentingan publikasi kepada panitia penyelenggara;</td>
        </tr>
        <tr>
            <td style="width: 5px; vertical-align: top;">4.</td>
            <td colspan="2">
                Peserta bersedia untuk melakukan pengukuran komposisi tubuh sesuai dengan prosedur yang ditetapkan oleh Kemenkes Bootcamp & Fitness Center pada waktu berikut: <br>
                a. Pengukuran ke-1 : 5 - 9 Agustus 2024 <br>
                b. Pengukuran ke-2 : 2 - 6 September 2024 <br>
                c. Pengukuran ke-3 : 30 September - 4 Oktober 2024 <br>
                d. Pengukuran akhir : 28 Oktober - 1 November 2024 <br>
                Peserta menerima hasil pengukuran komposisi tubuh sesuai dengan prosedur yang ditetapkan, hasil pengecekan dapat
                dilihat di dalam menu body composition pada aplikasi di Kemenkes Bootcamp & Fitness Center; <br>
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;">5.</td>
            <td colspan="2">
                Apabila peserta telah terdaftar sebagai bagian dari challenge namun tidak melakukan pengukuran komposisi tubuh sesuai dengan waktu yang ditentukan maka peserta didiskualifikasi atau dinyatakan gugur; <br>

        <tr>
            <td style="width: 5px; vertical-align: top;">6.</td>
            <td colspan="2">
                Kategori dalam challenge dibagi berdasarkan jenis kelamin dan jenis challenge sebagai berikut: <br>
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;"></td>
            <td style="width: 5px; vertical-align: top;">a. </td>
            <td>
                <b><i>Male Fat Loss Challenge:</i></b> Tantangan pemantauan progres hasil penurunan persentase lemak untuk laki-laki,
                dinilai berdasarkan penurunan persentase lemak (selisih penimbangan pertama dikurangi akhir)
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;"></td>
            <td style="width: 5px; vertical-align: top;">b. </td>
            <td>
                <b><i>Female Fat Loss Challenge:</i></b> Tantangan pemantauan progres hasil penurunan persentase lemak untuk perempuan,
                dinilai berdasarkan penurunan persentase lemak (selisih penimbangan pertama dikurangi akhir)
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;"></td>
            <td style="width: 5px; vertical-align: top;">c. </td>
            <td>
                <b><i>Male Muscle Gain Challenge:</i></b> Tantangan pemantauan progres hasil kenaikan massa otot untuk laki-laki,
                dinilai berdasarkan peningkatan massa otot (selisih penimbangan terakhir dikurangi pertama)
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;"></td>
            <td style="width: 5px; vertical-align: top;">d. </td>
            <td>
                <b><i>Female Muscle Gain Challenge:</i></b> Tantangan pemantauan progres hasil kenaikan massa otot untuk perempuan,
                dinilai berdasarkan peningkatan massa otot (selisih penimbangan terakhir dikurangi pertama)
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;">7.</td>
            <td colspan="2">Pemenang pada challenge adalah 3 (tiga) orang dengan progres terbaik pada setiap kategori;
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;">8.</td>
            <td colspan="2">
                Tantangan dilakukan secara aman dan nyaman, untuk itu peserta wajib melakukan konsultasi kepada dokter/ tenaga
                kesehatan yang berkompeten terkait kesehatan pribadi selama mengikuti challenge ini. Kesehatan diri pribadi
                selama pelaksanaan challenge ini menjadi tanggung jawab masing-masing peserta;
            </td>
        </tr>

        <tr>
            <td style="width: 5px; vertical-align: top;">9.</td>
            <td colspan="2">Keputusan tim pengelola Kemenkes Bootcamp & Fitness Center terhadap hasil dari challenge ini tidak dapat diganggu gugat.</td>
        </tr>

        <tr>
            <td colspan="3">
                <div style="margin-top: 30px">_______,____________</div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div style="height: 100px;"></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">{{ $detail->member->nama }}</td>
        </tr>

    </table>
</body>

</html>
