<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Konsultasi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KonsulController extends Controller
{
    public function show()
    {
        $dokter = Dokter::where('id_dokter', 1)->first();
        return view('dashboard.pages.konsul.show', compact('dokter'));
    }

    public function store(Request $request)
    {
        $user   = User::where('member_id', $request->member_id)->first();
        $konsul = Konsultasi::withTrashed()->count();

        $tambah = new Konsultasi();
        $tambah->id_konsultasi = $konsul + 1;
        $tambah->member_id     = $user->id;
        $tambah->dokter_id     = $request->dokter_id;
        $tambah->kode_book     = Konsultasi::count() + 1;
        $tambah->test_sipgar   = false;
        $tambah->test_fitness  = false;
        $tambah->konsultasi    = false;
        $tambah->created_at    = Carbon::now();
        $tambah->save();

        return redirect()->route('konsul')->with('success', 'Berhasil Booking Konsultasi!');
    }
}
