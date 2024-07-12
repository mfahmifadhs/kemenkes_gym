<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Konsultasi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class KonsulController extends Controller
{
    public function show()
    {
        $role   = Auth::user()->role_id;
        $dokter = Dokter::where('id_dokter', 1)->first();

        if ($role != 4) {
            $test    = ['Test Sipgar', 'Test Fitness', 'Konsul'];
            $konsul  = Konsultasi::get();
            return view('admin.pages.konsul.show', compact('dokter', 'konsul', 'test'));
        } else {
            $user   = User::where('id', Auth::user()->id)->first();
            $nama   = $user->nama;
            $asal   = $user->instansi == 'pusat' ? $user->uker->nama_unit_kerja : $user->nama_instansi;
            $phone  = '6285772652563';
            $msg    = "Halo coach, saya *$nama* dari *$asal*. %0ASaya ingin menjadwalkan Tes Vo2Max dengan SIPGAR dan Fitness Test sebelum Konsultasi dengan Dokter.";
            return view('dashboard.pages.konsul.show', compact('dokter', 'phone', 'msg'));
        }
    }

    public function store(Request $request)
    {
        $user    = User::where('member_id', $request->member_id)->first();
        $konsul  = Konsultasi::withTrashed()->count();

        $tambah = new Konsultasi();
        $tambah->id_konsultasi = $konsul + 1;
        $tambah->member_id     = $user->id;
        $tambah->dokter_id     = $request->dokter_id;
        $tambah->kode_book     = Konsultasi::where('konsultasi', false)->count() + 1;
        $tambah->test_sipgar   = false;
        $tambah->test_fitness  = false;
        $tambah->konsultasi    = false;
        $tambah->created_at    = Carbon::now();
        $tambah->save();

        return redirect()->route('konsul')->with('success', 'Berhasil Booking Konsultasi!');
    }

    public function cancel()
    {
        $user = Auth::user();
        $konsul = Konsultasi::where('member_id', $user->id)->where('konsultasi', false)->first();

        Konsultasi::where('id_konsultasi', $konsul->id_konsultasi)->delete();
        return redirect()->route('konsul')->with('success', 'Berhasil Membatalkan Konsultasi!');
    }

    public function update(Request $request, $id)
    {
        Konsultasi::where('id_konsultasi', $id)->update([
            'test_sipgar'   => (int) $request->test[1],
            'test_fitness'  => (int) $request->test[2],
        ]);

        if ($request->catatan_dokter || $request->catatan_pasien) {
            Konsultasi::where('id_konsultasi', $id)->update([
                'konsultasi'     => 1,
                'catatan_dokter' => $request->catatan_dokter,
                'catatan_pasien' => $request->catatan_pasien
            ]);
        }

        return redirect()->route('konsul')->with('success', 'Berhasil Proses Konsultasi!');
    }
}
