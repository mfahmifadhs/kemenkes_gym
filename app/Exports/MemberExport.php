<?php

namespace App\Exports;

use App\Models\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;


    function __construct($request)
    {
        $this->member_id = $request['col1'];
        $this->uker      = $request['searchUker'];
        $this->instansi  = $request['searchInst'];
        $this->nama      = $request['searchNama'];
        $this->nipnik    = $request['searchNip'];
        $this->email     = $request['searchMail'];
    }


    public function collection()
    {
        $data = User::where('role_id', 4)
            ->leftJoin('t_unit_kerja', 't_unit_kerja.id_unit_kerja', '=', 'users.uker_id')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY users.id) as no'),
                'users.nama',
                DB::raw("CONCAT('`', users.nip_nik) as nip_nik"),
                'users.instansi',
                DB::raw("CASE WHEN users.instansi = 'pusat' THEN t_unit_kerja.nama_unit_kerja ELSE users.nama_instansi END as nama_instansi"),
                'users.jenis_kelamin',
                'users.tanggal_lahir',
                'users.usia',
                'users.tinggi',
                'users.berat',
                'users.email',
                'users.no_telp'
            );

        if ($this->member_id || $this->instansi || $this->uker || $this->nama || $this->nipnik || $this->email) {
            if ($this->member_id) {
                $res = $data->where('member_id', 'like', '%' . $this->member_id . '%');
            }

            if ($this->instansi) {
                $res = $data->where('instansi', 'like', '%' . $this->instansi . '%');
            }

            if ($this->uker) {
                $res = $data->where(function ($query) {
                    $query->whereHas('uker', function ($subQuery) {
                        $subQuery->where('nama_unit_kerja', 'like', '%' . $this->uker . '%');
                    })
                        ->orWhere('nama_instansi', 'like', '%' . $this->uker . '%');
                });
            }

            if ($this->nama) {
                $res = $data->where('nama', 'like', '%' . $this->nama . '%');
            }

            if ($this->nipnik) {
                $res = $data->where('nip_nik', 'like', '%' . $this->nipnik . '%');
            }

            if ($this->email) {
                $res = $data->where('email', 'like', '%' . $this->email . '%');
            }
        } else {
            $res = $data;
        }

        $member = $res->get();
        return $member;
    }

    public function headings(): array
    {
        return ["NO", "NAMA", "NIP/NIK", "INSTANSI", "ASAL UNIT KERJA/INSTANSI/UPT", "JENIS KELAMIN", "TANGGAL LAHIR", "USIA", "TINGGI", "BERAT", "EMAIL", "NO. TELPON"];
    }
}
