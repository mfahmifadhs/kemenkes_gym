<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $roleId = Auth::user()->role_id;
        $kelas  = Kelas::orderBy('nama_kelas', 'ASC')->get();

        if ($roleId == 1) {
            return view('admin-master.dashboard');
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
