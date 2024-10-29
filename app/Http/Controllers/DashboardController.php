<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bodyck;
use App\Models\BodyckDetail;
use App\Models\BodyckParam;
use App\Models\Bodycp;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MinatKelas;
use App\Models\Penalty;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\Survey;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bkpk          = Auth::user()->uker?->unit_utama_id == 46591 ? true : null;
        $penalty       = $this->penalty();
        $totalUtama    = $this->totalMinatByUker();
        $totalKelas    = $this->totalMinatByKelas();
        $totalStatus   = $this->totalMinatByStatus();
        $today = Carbon::now()->startOfDay();

        $roleId = Auth::user()->role_id;
        $kelas  = Kelas::orderBy('nama_kelas', 'ASC')->where('status', 'true')->get();
        $jadwal = Jadwal::where('tanggal_kelas', $today)->get();
        $absen  = Absensi::where('tanggal', Carbon::now()->format('Y-m-d'))->get();
        $totalPeminatan = MinatKelas::count();
        $totalMember    = $bkpk ? User::join('t_unit_kerja', 'id_unit_kerja', 'uker_id')->where('unit_utama_id', '46591')->where('role_id', 4)->get() : User::where('role_id', 4)->get();
        $totalKepuasan  = Survey::get();

        if ($roleId == 1 || $roleId == 3) {
            return view('admin.dashboard', compact('totalPeminatan', 'totalMember', 'totalUtama', 'totalStatus', 'totalKelas', 'totalKepuasan', 'bkpk'));
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

        if ($roleId == 1 || $roleId == 3) {
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
            ->leftJoin('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->get(['t_bodyck.member_id', 't_bodyck_detail.nilai', 'users.nama', 'users.instansi', 'users.nama_instansi', 't_unit_kerja.nama_unit_kerja', 't_bodyck_detail.id_detail'])
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

    public function totalMinatByKelas()
    {
        $total = MinatKelas::join('users', 'id', 't_minat_kelas.member_id')
            ->join('t_kelas', 'id_kelas', 'kelas_id')
            ->select('id_kelas', 'nama_kelas', DB::raw('COUNT(t_minat_kelas.member_id) as total_member'))
            ->groupBy('id_kelas', 'nama_kelas')
            ->orderBy('total_member', 'DESC')
            ->get();

        return $total;
    }

    public function totalMinatByUker()
    {
        $bkpk = Auth::user()?->uker;
        $data = User::where('role_id', 4)
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
            ->select('id_unit_utama', 'nama_unit_utama', DB::raw('COUNT(id) as total_member'))
            ->groupBy('id_unit_utama', 'nama_unit_utama')
            ->orderBy('total_member', 'DESC');

        if ($bkpk->unit_utama_id == '46591') {
            $total = $data->where('unit_utama_id', '46591')->get();
        } else {
            $total = $data->get();
        }

        return $total;
    }

    public function totalMinatByStatus()
    {
        $total = User::where('role_id', 4)
            ->select(
                'instansi',
                DB::raw('COUNT(id) as total_member'),
                DB::raw('SUM(CASE WHEN nip_nik LIKE "19%" THEN 1 ELSE 0 END) as total_pns'),
                DB::raw('SUM(CASE WHEN nip_nik LIKE "9%" THEN 1 ELSE 0 END) as total_ppnpn')
            )
            ->groupBy('instansi')
            ->orderBy('total_member', 'DESC')
            ->get();

        return $total;
    }

    public function penalty()
    {
        $penalty = Penalty::where('user_id', Auth::user()->id)->where('status', 'false')->first();

        if ($penalty) {
            $tgl_awal = Carbon::now()->startOfDay();
            $tgl_akhir = Carbon::parse($penalty->tgl_akhir_penalty)->startOfDay();
            $total_hari = $tgl_awal->diffInDays($tgl_akhir, false);

            if ($total_hari <= 0) {
                Penalty::where('id_penalty', $penalty->id_penalty)->update([
                    'status' => 'true'
                ]);
            }
        }

        return true;
    }
}
