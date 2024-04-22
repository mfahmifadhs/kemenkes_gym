<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MinatKelas;
use App\Models\Target;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Hash;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function show()
    {
        $searchCol1 = '';
        $searchInst = '';
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

        return view('admin-master.pages.member.show', compact('member', 'uker', 'searchCol1', 'searchInst', 'searchUker', 'searchNama', 'searchNip', 'searchMail', 'searchCol7'));
    }

    public function search(Request $request)
    {
        $res = '';
        $perPage    = $request->get('perPage', 10);
        $searchCol1 = $request->get('col1'); // Member ID
        $searchInst = $request->get('searchInst'); // Tanggal
        $searchUker = $request->get('searchUker'); // Asal Unit Kerja
        $searchInst = $request->get('searchInst'); // Asal Instansi
        $searchNama = $request->get('searchNama'); // Nama
        $searchNip  = $request->get('searchNip'); // NIP NIK
        $searchMail = $request->get('searchMail'); // Email
        $searchCol7 = $request->get('col7'); // Telepon
        $data       = User::where('role_id', 4);
        $uker       = User::select('uker_id', 'nama_unit_kerja')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->groupBy('uker_id', 'nama_unit_kerja')
            ->orderBy('nama_unit_kerja', 'ASC')
            ->get();

        if ($searchCol1 || $searchInst || $searchUker || $searchNama || $searchNip || $searchMail || $searchCol7) {
            if ($searchCol1) {
                $res = $data->where('member_id', 'like', '%' . $searchCol1 . '%');
            }

            if ($searchInst) {
                $res = $data->where('instansi', 'like', '%' . $searchInst . '%');
            }

            if ($searchUker) {
                $res = $data->whereHas('uker', function ($query) use ($searchUker) {
                    $query->where('nama_unit_kerja', 'like', '%' . $searchUker . '%');
                })
                    ->orWhere('nama_instansi', 'like', '%' . $searchUker . '%');
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
            'searchInst' => $searchInst,
            'searchUker' => $searchUker,
            'searchNama' => $searchNama,
            'searchNip'  => $searchNip,
            'searchMail' => $searchMail,
            'searchCol7' => $searchCol7
        ]);

        return view('admin-master.pages.member.show', compact('member', 'uker', 'searchCol1', 'searchInst', 'searchUker', 'searchNama', 'searchNip', 'searchMail', 'searchCol7'));
    }

    public function detail($id)
    {
        $member = User::where('id', $id)->first();
        return view('admin-master.pages.member.detail', compact('member'));
    }

    public function edit($id)
    {
        $member = User::where('id', $id)->first();
        $utama  = UnitUtama::get();
        $uker   = UnitKerja::get();
        $kelas  = Kelas::get();
        $target = Target::get();
        return view('admin-master.pages.member.edit', compact('member', 'utama', 'uker', 'kelas', 'target'));
    }

    public function update(Request $request, $id)
    {
        $tanggal_lahir    = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir);
        $tanggal_sekarang = Carbon::now();
        $usia = $tanggal_lahir->diffInYears($tanggal_sekarang);

        $totalUser = User::count();
        $idUser    = $totalUser + 1;

        User::where('id', $id)->update([
            'role_id'        => $request->role ?? 4,
            'uker_id'        => $request->instansi == 'pusat' ? $request->uker : null,
            'nip_nik'        => $request->nipnik,
            'nama'           => $request->nama,
            'jenis_kelamin'  => $request->jkelamin,
            'tempat_lahir'   => strtoupper($request->tempat_lahir),
            'tanggal_lahir'  => $request->tanggal_lahir,
            'usia'           => $usia,
            'no_telp'        => $request->no_telp,
            'instansi'       => $request->instansi,
            'nama_instansi'  => $request->instansi != 'pusat' ? $request->nama_instansi : null,
            'tinggi'         => $request->tinggi,
            'berat'          => $request->berat
        ]);

        return redirect()->route('member.detail', $id)->with('success', 'Berhasil Menyimpan Perubahan');
    }


    public function delete($id)
    {
        $member = User::where('id', $id)->delete();
        return redirect()->route('member')->with('success', 'Berhasil Menghapus Data');
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
