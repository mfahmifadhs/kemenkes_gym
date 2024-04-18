<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Role;
use App\Models\Pegawai;
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
        $kelas = Kelas::orderBy('nama_kelas', 'ASC')->get();
        return view('dashboard.pages.kelas.show', compact('kelas'));
    }

    public function detail($id)
    {
        $kelas = Kelas::where('id_kelas', $id)->first();
        return view('dashboard.pages.kelas.detail', compact('id', 'kelas'));
    }
}
