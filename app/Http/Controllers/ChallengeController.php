<?php

namespace App\Http\Controllers;

use App\Models\BodyckDetail;
use App\Models\Bodycp;
use App\Models\Challenge;
use App\Models\ChallengeDetail;
use App\Models\Leaderboard;
use App\Models\UnitUtama;
use App\Models\User;
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
            $board  = Leaderboard::orderBy('id_leaderboard', 'ASC')->get();
            $member = User::where('role_id', 4)->orderBy('nama', 'ASC')->get();
            return view('admin.pages.challenge.show', compact('challenge','topFatLoss','topMuscleGain','utama','instansi','gender','member','board'));
        } else {
            $user = Auth::user()->id;
            $challenge = ChallengeDetail::where('member_id', $user)->first();
            $bodyCp    = Bodycp::orderBy('id_bodycp', 'DESC')->where('member_id', $user)
                ->whereBetween(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(tanggal_cek, ' ', 1), '%d/%m/%Y')"), ['2024-08-05', '2024-08-20'])
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
        $board     = [];
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

        return view('admin.pages.challenge.show', compact('challenge', 'topFatLoss', 'topMuscleGain', 'utama', 'instansi', 'gender', 'board'));
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

    public function topProgress()
    {
        $bodyCp = Bodycp::with('member', 'member.uker', 'member.challenge')
            ->whereBetween(DB::raw("STR_TO_DATE(tanggal_cek, '%d/%m/%Y')"), ['2024-08-05', '2024-08-20'])
            ->get()
            ->groupBy('member_id');

        $challenge = ChallengeDetail::pluck('member_id')->toArray(); // Ambil semua member_id dari challenge

        $results = [];

        foreach ($bodyCp as $member_id => $details) {
            // Cek apakah member_id ada di dalam challenge
            if (in_array($member_id, $challenge)) {
                // Mendapatkan hasil pertama dan terakhir
                $hasil_pertama = $details->first();
                $hasil_akhir   = $details->last();

                // Menghitung selisih FATP dan FATM
                $selisihFATP = $hasil_akhir->fatp - $hasil_pertama->fatp;
                $selisihFATM = $hasil_akhir->pmm - $hasil_pertama->pmm;

                // Menentukan nilai progress
                $progressFATP = $selisihFATP < 0 ? '+' . number_format(abs($selisihFATP), 1) : '-' . number_format((string) $selisihFATP, 1);
                $progressFATM = $selisihFATM < 0 ? '+' . number_format(abs($selisihFATM), 1) : '-' . number_format((string) $selisihFATM, 1);

                $member = $details->first()->member;
                $chall  = $details->first()->member->challenge->first()->challenge_id;
                $uker   = $member->instansi === 'pusat' ? $member->uker->nama_unit_kerja : $member->nama_instansi;
                $utama  = $member->instansi === 'pusat' ? $member->uker->unit_utama_id : '';

                if ($selisihFATP != 0 || $selisihFATM != 0) {
                    $results[$member_id] = [
                        'member_id' => $member->id,
                        'nama'      => $member->nama,
                        'gender'    => $member->jenis_kelamin,
                        'instansi'  => $member->instansi,
                        'utama'     => $utama,
                        'uker'      => $uker,
                        'challenge' => $chall   ,
                        'fatp_diff' => $progressFATP,
                        'fatm_diff' => $progressFATM
                    ];
                }
            }
        }

        // Mengurutkan array berdasarkan selisih FATP
        usort($results, function ($a, $b) {
            return abs($b['fatp_diff']) <=> abs($a['fatp_diff']);
        });

        return $results;
    }

    public function participantDetail($id)
    {
        $challenge = ChallengeDetail::where('member_id', $id)->first();
        $bodyCp    = Bodycp::orderBy('tanggal_cek', 'ASC')->where('member_id', $id)
            ->whereBetween(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(tanggal_cek, ' ', 1), '%d/%m/%Y')"), ['2024-08-05', '2024-08-20'])
            ->get();
        if (!$bodyCp) {
            return redirect()->route('challenge')->with('failed', 'Data Penimbangan Tidak Ditemukan');
        }

        return view('admin.pages.challenge.detail', compact('challenge', 'bodyCp'));
    }

    public function participantStore(Request $request)
    {
        $challenge = ChallengeDetail::where('member_id', $request->member)->count();

        if ($challenge != 0 || !$request->challenge_id) {
            return redirect()->route('challenge')->with('failed', 'Gagal, terjadi kesalahan!');
        } else {
            $detail = ChallengeDetail::withTrashed()->count() + 1;
            $tambah = new ChallengeDetail();
            $tambah->id_detail    = $detail;
            $tambah->challenge_id = $request->challenge_id;
            $tambah->member_id    = $request->member;
            $tambah->created_at   = Carbon::now();
            $tambah->save();

            return redirect()->route('challenge')->with('success', 'Berhasil mendaftarkan peserta!');
        }
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
        $pickChall = '';
        $utama     = UnitUtama::get();
        $challenge = Challenge::get();
        $board     = Leaderboard::orderBy('id_leaderboard', 'ASC')->get();
        $peserta   = ChallengeDetail::with('member')->get();

        $timbangan = $this->topProgress();

        return view('admin.pages.challenge.leaderboard', compact('board', 'peserta', 'challenge', 'timbangan', 'utama', 'instansi', 'gender','pickChall'));
    }

    public function leaderboardFilter(Request $request)
    {
        $tahapan = [
            ['title' => 'tahap1', 'startDate' => '2024-08-05', 'endDate' => '2024-08-20'],
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
        $dataChall  = $this->topProgress();

        if ($instansi || $unitUtama || $gender || $pickChall) {
            if ($instansi) {
                $result = array_filter($dataChall, function ($item) use ($instansi) {
                    return $item['instansi'] === $instansi;
                });
            }

            if ($unitUtama) {
                $result = array_filter($dataChall, function ($item) use ($unitUtama) {
                    return $item['utama'] === $unitUtama;
                });
            }

            if ($gender) {
                $result = array_filter($dataChall, function ($item) use ($gender) {
                    return $item['gender'] === $gender;
                });
            }

            if ($pickChall) {
                $result = array_filter($dataChall, function ($item) use ($pickChall) {
                    return $item['challenge'] === (int) $pickChall;
                });
            }

            $timbangan = $result;
        } else {
            $timbangan = $dataChall;
        }

        return view('admin.pages.challenge.leaderboard', compact('board', 'peserta', 'challenge', 'timbangan', 'utama', 'instansi', 'gender', 'pickChall'));
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

    public function tanitaDelete($id)
    {
        $detail = Bodycp::where('id_bodycp', $id)->first();
        Bodycp::where('id_bodycp', $id)->delete();
        return back()->with('success', 'Berhasil Menghapus Data');
    }
}
