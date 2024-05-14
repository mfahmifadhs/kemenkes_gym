<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bodyck;
use App\Models\BodyckDetail;
use App\Models\BodyckParam;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MinatKelas;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUtama    = $this->totalMinatByUker();
        $totalKelas    = $this->totalMinatByKelas();

        $roleId = Auth::user()->role_id;
        $kelas  = Kelas::orderBy('nama_kelas', 'ASC')->where('status', 'true')->get();
        $jadwal = Jadwal::where('tanggal_kelas', '>', Carbon::now())->get();
        $absen  = Absensi::where('tanggal', Carbon::now()->format('Y-m-d'))->get();
        $totalPeminatan = MinatKelas::count();
        $totalMember    = User::where('role_id', 4)->count();

        if ($roleId == 1) {
            return view('admin.dashboard', compact('totalPeminatan', 'totalMember', 'totalUtama', 'totalKelas'));
        } else if ($roleId == 4) {
            $role = 'member';
        } else {
            $role = 'admin';
        }

        return view('dashboard.' . $role, compact('kelas', 'absen', 'jadwal', 'totalMember', 'totalPeminatan'));
    }

    public function time()
    {
        $response = Carbon::now()->isoFormat('DD MMMM Y HH:mm:ss');
        return response()->json($response);
    }

    public function leaderboard()
    {
        $roleId = Auth::user()->role_id;
        $topFatLoss    = collect($this->topProgress(2))->take(10);
        $topMuscleMass = collect($this->topProgress(5))->take(10);

        if ($roleId == 1) {
            return view('admin.leaderboard', compact('topFatLoss', 'topMuscleMass'));
        } else {
            return view('dashboard.pages.leaderboard', compact('topFatLoss', 'topMuscleMass'));
        }
    }

    public function topProgress($paramId)
    {
        $bodyCkDetails = BodyckDetail::where('param_id', $paramId)
            ->join('t_bodyck', 'id_bodyck', 'bodyck_id')
            ->join('users', 'id', 't_bodyck.member_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->get(['t_bodyck.member_id', 't_bodyck_detail.nilai', 'users.nama', 't_unit_kerja.nama_unit_kerja', 't_bodyck_detail.id_detail'])
            ->groupBy('member_id');

        $results = [];
        foreach ($bodyCkDetails as $member_id => $details) {
            $details = $details->sortBy('id_detail');
            $hasil_pertama = $details->first()->nilai;
            $hasil_akhir = $details->last()->nilai;

            $resProgress = $hasil_pertama - $hasil_akhir;
            $member = $details->first();

            $progress = $resProgress < 0 ? '+' . abs($resProgress) : '-' . (string)$resProgress;

            if ($progress != 0) {
                $results[$member_id] = [
                    'nama' => $member->nama,
                    'uker' => $member->nama_unit_kerja,
                    'progress' => $progress
                ];
            }
        }

        // Mengurutkan array berdasarkan nilai fat_loss
        usort($results, function ($a, $b) {
            return abs($b['progress']) <=> abs($a['progress']);
        });

        return $results;
    }

    public function totalMinatByKelas()
    {
        $total = MinatKelas::join('users', 'id', 't_minat_kelas.member_id')
            ->join('t_kelas', 'id_kelas', 'kelas_id')
            ->select('id_kelas', 'nama_kelas', DB::raw('COUNT(t_minat_kelas.member_id) as total_member'))
            ->groupBy('id_kelas', 'nama_kelas')
            ->orderBy('nama_kelas', 'ASC')
            ->get();

        return $total;
    }

    public function totalMinatByUker()
    {
        $total = User::where('role_id', 4)
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
            ->select('id_unit_utama', 'nama_unit_utama', DB::raw('COUNT(id) as total_member'))
            ->groupBy('id_unit_utama', 'nama_unit_utama')
            ->orderBy('nama_unit_utama', 'ASC')
            ->get();

        return $total;
    }
}
