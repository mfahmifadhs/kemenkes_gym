<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Role;
use App\Models\Pegawai;
use App\Models\Peserta;
use App\Models\UnitKerja;
use Hash;
use Auth;
use Carbon\Carbon;
use Session;
use DB;

class KelasController extends Controller
{
    public function show()
    {
        $role  = Auth::user()->role_id;
        $data  = Kelas::orderBy('nama_kelas', 'ASC');
        $bkpk  = Auth::user()->uker->unit_utama_id;

        if ($bkpk == '46591') {
            $kelas = $data->where('id_kelas', 3)->get();
        } else {
            $kelas = $data->get();
        }


        if ($role == 1 || $role == 3) {
            return view('admin.pages.kelas.show', compact('kelas'));
        } else {
            return view('dashboard.pages.kelas.show', compact('kelas'));
        }
    }

    public function edit($id)
    {
        $kelas = Kelas::where('id_kelas', $id)->first();
        return view('admin.pages.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        Kelas::where('id_kelas', $id)->update([
            'nama_kelas' => $request->nama_kelas,
            'deskripsi'  => $request->deskripsi,
            'status'     => $request->status
        ]);

        return redirect()->route('kelas')->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public function detail($id)
    {
        $role   = Auth::user()->role_id;
        $kelas  = Kelas::where('id_kelas', $id)->first();
        $daftar = Peserta::where('member_id', Auth::user()->id)->first();

        if ($role == 1 || $role == 3) {
            return view('admin.pages.kelas.detail', compact('id', 'kelas', 'daftar'));
        } else {
            return view('dashboard.pages.kelas.detail', compact('id', 'kelas', 'daftar'));
        }
    }
}
