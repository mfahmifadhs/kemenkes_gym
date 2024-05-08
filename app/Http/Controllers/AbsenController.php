<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function show()
    {
        $colDate  = Carbon::now()->format('d');
        $colMonth = Carbon::now()->format('m');
        $colYear  = Carbon::now()->format('Y');
        $colUtama = '';
        $colUker  = '';

        $query    = Absensi::orderBy('id_absensi', 'DESC')
            ->where(DB::raw("DATE_FORMAT(tanggal, '%d')"), $colDate)
            ->where(DB::raw("DATE_FORMAT(tanggal, '%m')"), $colMonth)
            ->where(DB::raw("DATE_FORMAT(tanggal, '%Y')"), $colYear);

        if (Auth::user()->id == 4) {
            $absen = $query->where('user_id', Auth::user()->id)->paginate(10);
            return view('dashboard.pages.absen.show', compact('absen','colDate','colMonth','colYear','colUtama','colUker'));
        } else {
            $absen = $query->paginate(10);
            return view('admin.pages.absen.show', compact('absen','colDate','colMonth','colYear','colUtama','colUker'));
        }
    }

    public function store(Request $request, $id)
    {
        $user = User::where('member_id', $id)->first();

        $tambah = new Absensi();
        $tambah->user_id = $user->id;
        $tambah->tanggal = Carbon::now();
        $tambah->waktu_masuk = Carbon::now();
        $tambah->created_at  = Carbon::now();
        $tambah->save();

        return response()->json(['success' => true]);
    }
}
