<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MinatKelas;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $roleId = Auth::user()->role_id;
        $kelas  = Kelas::orderBy('nama_kelas', 'ASC')->get();
        $totalPeminatan = MinatKelas::count();
        $totalMember    = User::where('role_id', 4)->count();
        $totalUtama     = User::where('role_id', 4)
                          ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
                          ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
                          ->select('id_unit_utama', 'nama_unit_utama', DB::raw('COUNT(id) as total_member'))
                          ->groupBy('id_unit_utama', 'nama_unit_utama')
                          ->orderBy('nama_unit_utama', 'ASC')
                          ->get();

        $totalKelas     = MinatKelas::join('users', 'id', 't_minat_kelas.member_id')
                          ->join('t_kelas', 'id_kelas', 'kelas_id')
                          ->select('id_kelas', 'nama_kelas', DB::raw('COUNT(t_minat_kelas.member_id) as total_member'))
                          ->groupBy('id_kelas', 'nama_kelas')
                          ->orderBy('nama_kelas', 'ASC')
                          ->get();

        if ($roleId == 1) {
            return view('admin.dashboard', compact('totalPeminatan', 'totalMember', 'totalUtama', 'totalKelas'));
        } else if ($roleId == 4) {
            $role = 'member';
        } else {
            $role = 'admin';
        }

        return view('dashboard.' . $role, compact('kelas'));

    }

    public function time()
    {
        $response = Carbon::now()->isoFormat('DD MMMM Y HH:mm:ss');
        return response()->json($response);
    }
}
