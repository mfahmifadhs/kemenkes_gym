<?php

namespace App\Http\Controllers;

use App\Models\MinatKelas;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class MemberController extends Controller
{
    public function show()
    {
        $searchCol1 = '';
        $searchCol2 = '';
        $searchUker = '';
        $searchNama = '';
        $searchNip  = '';
        $searchMail = '';
        $searchCol7 = '';

        $member = User::where('role_id', 4)->paginate(10);
        $uker   = User::select('uker_id', 'nama_unit_kerja')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->groupBy('uker_id', 'nama_unit_kerja')
            ->orderBy('nama_unit_kerja', 'ASC')
            ->get();

        return view('admin-master.pages.member.show', compact('member', 'uker', 'searchCol1', 'searchCol2', 'searchUker', 'searchNama', 'searchNip', 'searchMail', 'searchCol7'));
    }

    public function search(Request $request)
    {
        $res = '';
        $perPage    = $request->get('perPage', 10);
        $searchCol1 = $request->get('col1'); // Member ID
        $searchCol2 = $request->get('col2'); // Tanggal
        $searchUker = $request->get('searchUker'); // Asal Unit Kerja
        $searchNama = $request->get('searchNama'); // Nama
        $searchNip  = $request->get('searchNip'); // NIP NIK
        $searchMail = $request->get('searchMail'); // Email
        $searchCol7 = $request->get('col7'); // Telepon
        $data       = User::where('role_id', 4);
        $uker       = User::select('uker_id', 'nama_unit_kerja')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->groupBy('uker_id', 'nama_unit_kerja')
            ->orderBy('nama_unit_kerja', 'ASC')
            ->get();

        if ($searchCol1 || $searchCol2 || $searchUker || $searchNama || $searchNip || $searchMail || $searchCol7) {
            if ($searchCol1) {
                $res = $data->where('member_id', 'like', '%' . $searchCol1 . '%');
            }

            if ($searchCol2) {
                $res = $data->where('created_at', 'like', '%' . $searchCol2 . '%');
            }

            if ($searchUker) {
                $res = $data->where('nama_instansi', 'like', '%' . $searchUker . '%')
                    ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id');
            }

            if ($searchNama) {
                $res = $data->where('nama', 'like', '%' . $searchNama . '%');
            }

            if ($searchNip) {
                $res = $data->where('nip_nik', 'like', '%' . $searchNip . '%');
            }

            if ($searchMail) {
                $res = $data->where('email', 'like', '%' . $searchMail . '%');
            }

            if ($searchCol7) {
                $res = $data->where('no_telp', 'like', '%' . $searchCol7 . '%');
            }
        }

        $resArr = !$res ? $data : $res;

        $member = $resArr->paginate($perPage);

        $member->appends([
            'searchCol1' => $searchCol1,
            'searchCol2' => $searchCol2,
            'searchUker' => $searchUker,
            'searchNama' => $searchNama,
            'searchNip'  => $searchNip,
            'searchMail' => $searchMail,
            'searchCol7' => $searchCol7
        ]);

        return view('admin-master.pages.member.show', compact('member', 'uker', 'searchCol1', 'searchCol2', 'searchUker', 'searchNama', 'searchNip', 'searchMail', 'searchCol7'));
    }

    public function edit($id)
    {
        $member = User::where('member_id', $id)->first();
        return view('admin-master.pages.member.edit', compact('member'));
    }

    public function chartAll()
    {
        $result = MinatKelas::join('t_kelas', 'id_kelas', 'kelas_id')
            ->select('nama_kelas', 'kelas_id', DB::raw('COUNT(member_id) as total_member'))
            ->groupBy('nama_kelas', 'kelas_id')
            ->orderBy('kelas_id')
            ->get();

        // Menampilkan hasil dalam format JSON
        return response()->json($result);
    }
}
