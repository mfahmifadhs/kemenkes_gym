<?php

namespace App\Exports;

use App\Models\Absensi;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsenExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;


    function __construct($request)
    {
        $this->tanggal = $request['tanggal'];
        $this->bulan   = $request['bulan'];
        $this->tahun   = $request['tahun'];
        $this->utama   = $request['utama'];
        $this->uker    = $request['uker'];
    }


    public function collection()
    {
        $data = Absensi::join('users', 'id', 'user_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->leftjoin('t_jadwal', 'id_jadwal', 'jadwal_id')
            ->leftjoin('t_kelar', 'id_jadwal', 'jadwal_id')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY id_absensi) as no'),
                'tanggal',
                'nama',
                'nama_unit_kerja',
                'waktu_masuk',
                'waktu_keluar',
                DB::raw("COALESCE(nama_kelas, 'exercise') as nama_kelas")
            );

        if ($this->tanggal || $this->bulan || $this->tahun || $this->utama || $this->uker) {
            if ($this->tanggal) {
                $res  = $data->where(DB::raw("DATE_FORMAT(tanggal, '%d')"), $this->tanggal);
            }

            if ($this->bulan) {
                $res  = $data->where(DB::raw("DATE_FORMAT(tanggal, '%m')"), $this->bulan);
            }

            if ($this->tahun) {
                $res  = $data->where(DB::raw("DATE_FORMAT(tanggal, '%Y')"), $this->tahun);
            }

            if ($this->utama) {
                $res  = $data->where('unit_utama_id', $this->utama);
            }

            if ($this->uker) {
                $res  = $data->where('unit_utama_id', $this->uker);
            } else {
                $area = '';
            }
        } else {
            $res    = $data;
        }

        $absen = $res->get();
        return $absen;
    }

    public function headings(): array
    {
        return ["NO", "TANGGAL", "NAMA", "UNIT KERJA", "WAKTU MASUK", "WAKTU KELUAR", "LATIHAN"];
    }
}
