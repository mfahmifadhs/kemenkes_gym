<?php

namespace App\Http\Controllers;

use App\Models\BodyckDetail;
use App\Models\Bodycp;
use App\Models\Challenge;
use App\Models\ChallengeDetail;
use App\Models\Leaderboard;
use App\Models\UnitUtama;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Auth;
use DB;

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
            return view('admin.pages.challenge.show', compact('challenge', 'topFatLoss', 'topMuscleGain', 'utama', 'instansi', 'gender'));
        } else {
            $user = Auth::user()->id;
            $challenge = ChallengeDetail::where('member_id', $user)->first();
            $bodyCp    = Bodycp::orderBy('id_bodycp', 'ASC')->where('member_id', $user)
                ->whereBetween(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(tanggal_cek, ' ', 1), '%d/%m/%Y')"), ['2024-08-05', '2024-08-09'])
                ->get();

            if (!$challenge) {
                return redirect()->route('dashboard')->with('failed', 'Pendaftaran Challenge Sudah Ditutup');
            }

            if (!$bodyCp) {
                return redirect()->route('dashboard')->with('failed', 'Data Penimbangan Tidak Ditemukan');
            }

            return view('dashboard.pages.challenge.show', compact('check', 'challenge', 'bodyCp'));
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

        return view('admin.pages.challenge.show', compact('challenge', 'topFatLoss', 'topMuscleGain', 'utama', 'instansi', 'gender'));
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

    public function leaderboard()
    {
        $instansi  = '';
        $gender    = '';
        $utama     = UnitUtama::get();
        $challenge = Challenge::get();
        $board     = Leaderboard::orderBy('id_leaderboard', 'ASC')->get();
        $peserta   = ChallengeDetail::with('member')->get();

        $timbangan = Bodycp::orderBy('id_bodycp', 'ASC')
            ->whereBetween(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(tanggal_cek, ' ', 1), '%d/%m/%Y')"), ['2024-08-05', '2024-08-09'])
            ->get();

        return view('admin.pages.challenge.leaderboard', compact('board', 'peserta', 'challenge', 'timbangan', 'utama', 'instansi', 'gender'));
    }

    public function leaderboardFilter(Request $request)
    {
        $tahapan = [
            ['title' => 'tahap1', 'startDate' => '2024-08-05', 'endDate' => '2024-08-09'],
            ['title' => 'tahap2', 'startDate' => '2024-09-02', 'endDate' => '2024-09-06'],
            ['title' => 'tahap3', 'startDate' => '2024-10-01', 'endDate' => '2024-10-04'],
            ['title' => 'tahap4', 'startDate' => '2024-10-28', 'endDate' => '2024-10-31'],
        ];

        $instansi   = $request->get('instansi');
        $unitUtama  = $request->get('utama');
        $gender     = $request->get('gender');
        $tahap      = $request->get('tahap');
        $board      = Leaderboard::orderBy('id_leaderboard', 'ASC')->get();
        $pilihTahap = collect($tahapan)->firstWhere('title', $tahap);
        $pickChall  = $request->get('challenge');
        $challenge  = Challenge::get();
        $utama      = UnitUtama::get();
        $peserta    = ChallengeDetail::with('member')->get();
        $bodyCp     = Bodycp::with('member', 'member.uker')->orderBy('id_bodycp', 'ASC');
        $dataChall  = ChallengeDetail::with('member','challenge')->orderBy('id_detail', 'ASC');

        if ($instansi || $tahap || $unitUtama || $gender || $pickChall) {
            if ($instansi) {
                $result = $dataChall->whereHas('member', function ($query) use ($instansi) {
                    $query->where('instansi', $instansi);
                });
            }

            if ($unitUtama) {
                $result = $dataChall->whereHas('member.uker', function ($query) use ($unitUtama) {
                    $query->where('unit_utama_id', $unitUtama);
                });
            }

            if ($tahap) {
                $result = $bodyCp->whereBetween(
                    DB::raw("STR_TO_DATE(SUBSTRING_INDEX(tanggal_cek, ' ', 1), '%d/%m/%Y')"),
                    [$pilihTahap['startDate'], $pilihTahap['endDate']]
                );
            }

            if ($gender) {
                $result = $dataChall->whereHas('member', function ($query) use ($gender) {
                    $query->where('jenis_kelamin', $gender);
                });
            }

            if ($pickChall) {
                $result = $dataChall->whereHas('challenge', function ($query) use ($challenge) {
                    $query->where('challenge_id', $challenge);
                });
            }

            $timbangan = $result->get();
        }

        return view('admin.pages.challenge.leaderboard', compact('board', 'peserta', 'challenge', 'timbangan', 'utama', 'instansi', 'gender'));
    }

    public function leaderboardUpdate(Request $request, $id)
    {
        $member = $request->get('member_id');
        $nilai  = $request->get('nilai');

        Leaderboard::where('id_leaderboard', $id)->update([
            'member_id' => $member,
            'nilai'     => $nilai
        ]);

        return redirect()->route('challenge.leaderboard')->with('success', 'Berhasil menyimpan pemenang');
    }

    public function leaderboardDelete($id)
    {
        Leaderboard::where('id_leaderboard', $id)->update([
            'member_id' => null,
            'nilai'     => null
        ]);

        return redirect()->route('challenge.leaderboard')->with('success', 'Berhasil menghapus pemenang');
    }
}
