<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Auth;

class ChallengeController extends Controller
{
    public function index()
    {
        $check = ChallengeDetail::where('member_id', Auth::user()->id)->first();
        return view('dashboard.pages.challenge.show', compact('check'));
    }

    public function detail($id)
    {
        $kode  = $id == 'fatloss' ? 1 : 2;
        $judul = $id == 'fatloss' ? 'Fat Loss Challenge' : 'Muscle Gain Challenge';
        $foto  = $id == 'fatloss' ? 'https://cdn-icons-png.flaticon.com/128/3136/3136101.png' : 'https://cdn-icons-png.flaticon.com/128/10916/10916574.png';

        return view('dashboard.pages.challenge.detail', compact('id', 'judul', 'foto', 'kode'));
    }

    public function join(Request $request, $id)
    {
        $detail = ChallengeDetail::withTrashed()->count() + 1;

        $tambah = new ChallengeDetail();
        $tambah->id_detail    = $detail;
        $tambah->challenge_id = $request->challenge_id;
        $tambah->member_id    = $id;
        $tambah->created_at   = Carbon::now();
        $tambah->save();

        return redirect()->route('challenge.ticket', $detail);
    }

    public function ticket($id)
    {
        $data = ChallengeDetail::where('id_detail', $id)->first();
        return view('dashboard.pages.challenge.ticket', compact('data'));
    }

    public function download($id, $form)
    {
        if ($form == 'pernyataan') {
            $detail = ChallengeDetail::where('id_detail', $id)->first();
            $pdf = PDF::loadView('dashboard.pages.challenge.form', compact('detail'));
            return $pdf->download('challenge.pdf');
        } else {
            $detail = ChallengeDetail::where('id_detail', $id)->first();
            $pdf = PDF::loadView('dashboard.pages.challenge.monitor', compact('detail'));
            return $pdf->download('lembar_monitoring.pdf');
        }
    }
}
