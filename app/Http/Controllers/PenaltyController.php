<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use App\Models\UnitUtama;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function show()
    {
        $utama   = UnitUtama::get();
        $penalty = Penalty::where('status', 'false')->get();
        return view('admin.pages.penalty.show', compact('utama', 'penalty'));
    }

    public function update(Request $request, $id)
    {
        Penalty::where('id_penalty', $id)->update([
            'kelas_id' => $request->kelas_id,
            'tgl_awal_penalty'  => $request->tgl_awal_penalty,
            'tgl_akhir_penalty' => $request->tgl_akhir_penalty,
            'status'            => $request->status,
        ]);

        return redirect()->route('penalty')->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public function delete($id)
    {
        Penalty::where('id_penalty', $id)->delete();
        return redirect()->route('penalty')->with('success', 'Berhasil Menghapus Data');
    }
}
