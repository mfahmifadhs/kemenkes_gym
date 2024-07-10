<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use App\Models\UnitUtama;
use Illuminate\Http\Request;
use Auth;

class PenaltyController extends Controller
{
    public function show()
    {
        $upl   = Auth::user()->uker_id;
        $utama = UnitUtama::get();
        $dataPenalty = Penalty::where('t_penalty.status', 'false');

        if ($upl == '121103') {
            $penalty = $dataPenalty->join('t_jadwal','id_jadwal','jadwal_id')->whereIn('kelas_id', [12,13,14])->get();
        } else {
            $penalty = $dataPenalty->get();
        }

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
