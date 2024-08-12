<?php

namespace App\Http\Controllers;

use App\Models\BodyckDetail;
use App\Models\Challenge;
use App\Models\ChallengeDetail;
use App\Models\UnitUtama;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Auth;

class ChallengeController extends Controller
{
    public function index()
    {
        $instansi  = '';
        $gender    = '';
        $role      = Auth::user()->role_id;
        $challenge = ChallengeDetail::get();
        $check     = ChallengeDetail::where('member_id', Auth::user()->id)->first();
        $utama     = UnitUtama::get();

        $topFatLoss    = collect($this->topProgress(2))->take(3);
        $topMuscleGain = collect($this->topProgress(5))->take(3);

        if ($role != 4) {
            return view('admin.pages.challenge.show', compact('challenge', 'topFatLoss', 'topMuscleGain', 'utama', 'instansi','gender'));
        } else {
            return view('dashboard.pages.challenge.show', compact('check'));
        }
    }

    public function filter(Request $request)
    {
        $instansi  = $request->get('instansi');
        $unitUtama = $request->get('utama');
        $gender    = $request->get('gender');
        $data      = ChallengeDetail::with('member');

        $utama     = UnitUtama::get();
        $topFatLoss    = collect($this->topProgress(2))->take(3);
        $topMuscleGain = collect($this->topProgress(5))->take(3);

        if ($instansi || $unitUtama || $gender) {
            if ($instansi) {
                $data = $data->whereHas('member', function ($query) use ($instansi) {
                    $query->where('instansi', $instansi);
                });
            }

            if ($unitUtama) {
                $data = $data->whereHas('member.uker', function ($query) use ($unitUtama) {
                    $query->where('unit_utama_id', $unitUtama);
                });
            }

            if ($gender) {
                $data = $data->whereHas('member', function ($query) use ($gender) {
                    $query->where('jenis_kelamin', $gender);
                });
            }
            $challenge = $data->get();
        } else {
            $challenge = $data->get();
        }

        return view('admin.pages.challenge.show', compact('challenge','topFatLoss','topMuscleGain','utama','instansi','gender'));
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

    public function topProgress($paramId)
    {
        $bodyCkDetails = BodyckDetail::where('param_id', $paramId)
            ->join('t_bodyck', 'id_bodyck', 'bodyck_id')
            ->join('users', 'id', 't_bodyck.member_id')
            ->leftJoin('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->get(['t_bodyck.member_id', 't_bodyck_detail.nilai', 'users.nama', 'users.instansi', 'users.nama_instansi', 't_unit_kerja.nama_unit_kerja', 't_bodyck_detail.id_detail'])
            ->where('t_bodyck.tanggal', '>=', '2024-08-05')
            ->groupBy('member_id');

        $results = [];
        foreach ($bodyCkDetails as $member_id => $details) {
            $details = $details->sortBy('id_detail');
            $hasil_pertama = $details->first()->nilai;
            $hasil_akhir = $details->last()->nilai;

            $resProgress = $hasil_pertama - $hasil_akhir;
            $member = $details->first();

            $progress = $resProgress < 0 ? '-' . abs($resProgress) : '+' . (string)$resProgress;
            $uker = $member->instansi === 'pusat' ? $member->nama_unit_kerja : $member->nama_instansi;

            if ($progress != 0) {
                $results[$member_id] = [
                    'nama' => $member->nama,
                    'uker' => $uker,
                    'progress' => $progress,
                    'satuan' => $paramId == 2 ? '%' : 'kg'
                ];
            }
        }

        // Mengurutkan array berdasarkan nilai fat_loss
        usort($results, function ($a, $b) {
            return abs($b['progress']) <=> abs($a['progress']);
        });

        return $results;
    }

    public function participantUpdate(Request $request, $id)
    {
        ChallengeDetail::where('id_detail', $id)->update([
            'challenge_id' => $request->get('challenge_id')
        ]);
        return redirect()->route('challenge')->with('success', 'Berhasil Memperbaharui Data!');
    }

    public function participantDelete($id)
    {
        ChallengeDetail::where('id_detail', $id)->delete();
        return redirect()->route('challenge')->with('success', 'Berhasil Menghapus Data!');
    }
}
