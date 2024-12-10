<?php

namespace App\Exports;

use App\Models\Konsultasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class KonsulExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data     = Konsultasi::join('users', 'id', 't_konsultasi.member_id')
            ->join('t_dokter', 'id_dokter', 'dokter_id')
            ->leftjoin('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->leftjoin('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY id_konsultasi) as no'),
                'tanggal_konsul',
                'waktu_konsul',
                'antrian_konsul',
                'nama_dokter',
                'id',
                'nama',
                DB::raw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as usia"),
                DB::raw("COALESCE(nama_unit_utama, instansi) as nama_unit_utama"),
                DB::raw("COALESCE(nama_unit_kerja, nama_instansi) as nama_unit_kerja"),
                'hasil_backs',
                'hasil_dynamo_r',
                'hasil_dynamo_l',
                'hasil_plank',
                'hasil_situp',
                'catatan_dokter',
                'catatan_pasien',
                DB::raw("(SELECT weight FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as berat"),
                DB::raw("(SELECT height FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as tinggi"),
                DB::raw("(SELECT fatm FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as fat"),
                DB::raw("(SELECT pmm FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as muscle"),
                DB::raw("(SELECT bonem FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as bone"),
                DB::raw("(SELECT metaage FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as age"),
                DB::raw("(SELECT vfatl FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as visceral"),
                DB::raw("(SELECT bmi FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as bmi"),
                DB::raw("(SELECT bmr FROM t_bodycp WHERE t_bodycp.member_id = users.id ORDER BY id_bodycp DESC LIMIT 1) as bmr"),

            )->where('konsultasi', 1)->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            "NO",
            "TANGGAL",
            "WAKTU",
            "NO.ANTRIAN",
            "DOKTER",
            "MEMBER ID",
            "NAMA",
            "USIA",
            "UNIT ESELON I",
            "UNIT ESELON II",
            "BACK & STRETCH",
            "HANDGRIP DYNAMOMETER (KIRI)",
            "HANDGRIP DYNAMOMETER (KANAN)",
            "PLANK",
            "SIT UP",
            "CATATAN DOKTER",
            "CATATAN PASIEN",
            "BERAT BADAN",
            "TINGGI BADAN",
            "LEMAK",
            "MASA OTOT",
            "MASA TULANG",
            "USIA METABOLISME",
            "VISCERAL FAT",
            "BMI",
            "BMR"
        ];
    }
}
