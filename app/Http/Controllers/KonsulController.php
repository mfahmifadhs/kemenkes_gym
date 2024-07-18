<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Konsultasi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use PDF;

class KonsulController extends Controller
{
    public function show()
    {
        $role   = Auth::user()->role_id;
        $dokter = Dokter::where('id_dokter', 1)->first();

        if ($role != 4) {
            $test    = ['Test Sipgar', 'Test Fitness', 'Konsul'];
            $konsul  = Konsultasi::paginate(4);
            $konsulAll = Konsultasi::get();
            return view('admin.pages.konsul.show', compact('dokter', 'konsul','konsulAll','test'));
        } else {
            $user       = User::where('id', Auth::user()->id)->first();
            $nama       = $user->nama;
            $asal       = $user->instansi == 'pusat' ? $user->uker->nama_unit_kerja : $user->nama_instansi;
            $userKonsul = Auth::user()->konsul->where('status', 'false');
            $phone      = '62895361160934';
            $msg        = "Halo coach, saya *$nama* dari *$asal*. %0ASaya ingin menjadwalkan Tes Vo2Max dengan SIPGAR dan Fitness Test sebelum Konsultasi dengan Dokter.";
            return view('dashboard.pages.konsul.show', compact('dokter', 'phone', 'msg', 'userKonsul'));
        }
    }

    public function detail($id)
    {
        $dokter = Dokter::where('id_dokter', 1)->first();
        $konsul = Konsultasi::where('id_konsultasi', $id)->first();
        return view('admin.pages.konsul.detail', compact('id', 'dokter', 'konsul'));
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
            'test_sipgar'   => (int) $request->sipgar,
            'test_fitness'  => (int) $request->fitness,
        ]);

        if ($request->tanggal_konsul && $request->waktu_konsul && !$request->catatan_dokter && !$request->catatan_pasien) {
            Konsultasi::where('id_konsultasi', $id)->update([
                'tanggal_konsul' => $request->tanggal_konsul,
                'waktu_konsul'   => $request->waktu_konsul,
            ]);
        } elseif ($request->tanggal_konsul && $request->catatan_dokter && $request->catatan_pasien) {
            Konsultasi::where('id_konsultasi', $id)->update([
                'konsultasi'     => 1,
                'catatan_dokter' => $request->catatan_dokter,
                'catatan_pasien' => $request->catatan_pasien
            ]);
        }

        return redirect()->route('konsul.detail', $id)->with('success', 'Berhasil Proses Konsultasi!');
    }

    public function delete($id)
    {
        Konsultasi::where('id_konsultasi', $id)->delete();
        return redirect()->route('konsul')->with('success', 'Berhasil Menghapus Data!');
    }

    public function reset()
    {
        $konsul = Konsultasi::where('member_id', Auth::user()->id)->where('status', 'false')->first();

        Konsultasi::where('id_konsultasi', $konsul->id_konsultasi)->update([
            'status' => 'true'
        ]);

        return redirect()->route('konsul')->with('success', 'Berhasil Reset Konsultasi!');
    }

    public function download($id)
    {
        $konsul = Konsultasi::where('id_konsultasi', $id)->first();
        $pdf = PDF::loadView('admin.pages.konsul.pdf', compact('konsul'));
        return $pdf->download('result.pdf');
    }
}
