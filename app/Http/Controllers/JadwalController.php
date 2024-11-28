<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Penalty;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;

class JadwalController extends Controller
{
    public function show()
    {
        $bkpk       = Auth::user()->uker?->unit_utama_id;
        $upl        = Auth::user()->uker_id;
        $role       = Auth::user()->role_id == 4 ? 'dashboard.pages.kelas' : 'admin.pages';
        $tglAwal    = Carbon::now();
        $tglAkhir   = Carbon::now()->endOfMonth();
        $tglAwalBulanBerikutnya = $tglAkhir->copy()->addDay();
        $tglAkhirBulanBerikutnya = $tglAkhir->copy()->addMonth()->endOfMonth();

        $range = collect(Carbon::parse($tglAwal)->range($tglAkhirBulanBerikutnya))->map(function ($date) {
            return $date->format('d-M-Y');
        });

        $rangeAwal  = Carbon::createFromFormat('d-m-Y', Carbon::now()->format('d-m-Y'));
        // $rangeAkhir = Carbon::createFromFormat('d-m-Y', Carbon::now()->endOfMonth()->format('d-m-Y'));
        // $ranges     = range($rangeAwal->day, $rangeAkhir->day);
        $today      = Carbon::now()->format('d-M-Y');

        $dataJadwal = Jadwal::select(DB::raw("DATE_FORMAT(tanggal_kelas, '%a') as hari"), 't_jadwal.*')
            ->where(DB::raw("DATE_FORMAT(tanggal_kelas, '%d-%b-%Y')"), $today)
            ->orderBy('waktu_mulai', 'DESC');

        $daftar = Peserta::where('member_id', Auth::user()->id)->first();
        $id     = $today;

        if ($role != 4 && $upl == '121103') {
            $jadwal = $dataJadwal->whereIn('kelas_id', [12,13,14])->get();
        } else if ($role != 4 && $bkpk == '46591') {
            $jadwal = $dataJadwal->get();
        } else {
            $jadwal = $dataJadwal->where('lokasi_id', null)->get();
        }

        return view($role . '.jadwal.show', compact('id', 'jadwal', 'range', 'rangeAwal', 'today', 'daftar'));
    }

    public function detail($id)
    {
        $upl   = Auth::user()->uker_id;
        $role  = Auth::user()->role_id;
        $jadwal = Jadwal::where('id_jadwal', $id)->first();

        if ($role == 1 || $role == 3) {
            return view('admin.pages.jadwal.detail', compact('jadwal'));
        } else {
            return view('dashboard.pages.kelas.jadwal.detail', compact('jadwal'));
        }
    }

    public function filter($id)
    {
        $bkpk       = Auth::user()->uker;
        $upl        = Auth::user()->uker_id;
        $role       = Auth::user()->role_id == 4 ? 'dashboard.pages.kelas' : 'admin.pages';
        $tglAwal    = Carbon::now();
        $tglAkhir   = Carbon::now()->endOfMonth();
        $tglAwalBulanBerikutnya = $tglAkhir->copy()->addDay();
        $tglAkhirBulanBerikutnya = $tglAkhir->copy()->addMonth()->endOfMonth();

        $range = collect(Carbon::parse($tglAwal)->range($tglAkhirBulanBerikutnya))->map(function ($date) {
            return $date->format('d-M-Y');
        });

        $rangeAwal  = Carbon::createFromFormat('d-m-Y', Carbon::now()->format('d-m-Y'));
        // $rangeAkhir = Carbon::createFromFormat('d-m-Y', Carbon::now()->endOfMonth()->format('d-m-Y'));
        // $ranges     = range($rangeAwal->day, $rangeAkhir->day);
        $today      = $id;
        $status = ''; // default status
        $dataJadwal     = Jadwal::select(DB::raw("DATE_FORMAT(tanggal_kelas, '%d-%b-%Y') as hari"), 't_jadwal.*')
            ->where(DB::raw("DATE_FORMAT(tanggal_kelas, '%d-%b-%Y')"), $id)
            ->orderBy('waktu_mulai', 'ASC');

        $daftar     = Peserta::where('member_id', Auth::user()->id)->first();

        if ($role != 4 && $upl == '121103') {
            $jadwal = $dataJadwal->whereIn('kelas_id', [12,13,14])->get();
        } else if ($role != 4 && $bkpk->unit_utama_id == '46591') {
            $jadwal = $dataJadwal->get();
        } else {
            $jadwal = $dataJadwal->where('lokasi_id', null)->get();
        }

        return view($role . '.jadwal.show', compact('id', 'jadwal', 'range', 'rangeAwal', 'today', 'daftar', 'status'));
    }

    public function create($id)
    {
        $date  = '';
        $role  = Auth::user()->role_id;
        $kelas = Kelas::where('id_kelas', $id)->first();

        if ($role == 1 || $role == 3) {
            return view('admin.pages.jadwal.create', compact('kelas', 'date'));
        } else {
            return view('dashboard.pages.kelas.jadwal.create', compact('kelas'));
        }
    }

    public function createByDate($id)
    {
        $date  = Carbon::parse($id)->format('Y-m-d');
        $role  = Auth::user()->role_id;
        $kelas = Kelas::orderBy('nama_kelas', 'ASC')->get();

        return view('admin.pages.jadwal.createbydate', compact('kelas', 'date', 'id'));
    }

    public function store(Request $request)
    {
        $bkpk  = Auth::user()->uker->unit_utama_id;
        $dataHari = Jadwal::where('kelas_id', $request->kelas_id)->whereDate('tanggal_kelas', '=', date('Y-m-d', strtotime($request->tanggal)));

        if ($bkpk == '46591') {
            $cekHari = $dataHari->where('lokasi_id', 2)->count();
        } else {
            $cekHari = $dataHari->count();
        }

        if ($cekHari != 0) {
            return redirect()->route('kelas.detail', $request->kelas_id)->with('failed', 'Jadwal sudah tersedia!');
        }

        $tambah = new Jadwal();
        $tambah->kelas_id       = $request->kelas_id;
        $tambah->lokasi_id      = $request->lokasi_id ?? null;
        $tambah->tanggal_kelas  = $request->tanggal;
        $tambah->waktu_mulai    = $request->waktu_mulai;
        $tambah->waktu_selesai  = $request->waktu_selesai;
        $tambah->kuota          = $request->kuota;
        $tambah->nama_pelatih   = $request->nama_pelatih;
        $tambah->lokasi         = $request->lokasi;
        $tambah->save();

        $date = Carbon::parse($request->tanggal)->format('d-M-Y');


        if ($bkpk == '46591') {
            return redirect()->route('kelas.detail', $request->kelas_id)->with('success', 'Berhasil membuat jadwal!');
        }

        return redirect()->route('jadwal.pilih', $date)->with('success', 'Berhasil membuat jadwal!');
    }

    public function edit($id)
    {
        $role = Auth::user()->role_id;
        $jadwal = Jadwal::where('id_jadwal', $id)->first();

        if ($role == 1 || $role == 3) {
            return view('admin.pages.jadwal.edit', compact('jadwal'));
        } else {
            return view('dashboard.pages.kelas.jadwal.edit', compact('jadwal'));
        }
    }

    public function update(Request $request, $id)
    {
        // $hari   = Carbon::parse($request->tanggal)->format('D');
        // $cekHari = Jadwal::where('kelas_id', $request->kelas_id)->where(DB::raw("DATE_FORMAT(tanggal_kelas, '%a')"), '!=', $hari)->count();

        // if ($cekHari != 0) {
        //     return redirect()->route('kelas.detail', $request->kelas_id)->with('failed', 'Please Choose Date with the same Days Name');
        // }

        Jadwal::where('id_jadwal', $id)->update([
            'kelas_id'      => $request->kelas_id,
            'tanggal_kelas' => $request->tanggal,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'kuota'         => $request->kuota,
            'nama_pelatih'  => $request->nama_pelatih,
            'lokasi'        => $request->lokasi
        ]);

        return redirect()->route('kelas.detail', $request->kelas_id)->with('success', 'Berhasil memperbaharui jadwal!');
    }

    public function join(Request $request, $id)
    {
        $role = Auth::user()->role_id;
        $jadwal  = Jadwal::where('id_jadwal', $id)->first();
        $daftar  = Peserta::where('member_id', Auth::user()->id)->where('jadwal_id', $id)->where('tanggal_latihan', $jadwal->tanggal_kelas)->first();

        if ($request->all() == []) {
            $tglNow     = Carbon::now()->startOfDay();
            $tglLatihan = Carbon::parse($jadwal->tanggal_kelas)->startOfDay();
            $jamNow     = Carbon::now();
            $jamLatihan = Carbon::parse($jadwal->waktu_mulai);

            $totalHari  = $tglNow->diffInDays($tglLatihan, false);
            $totalJam   = $jamNow->diffInMinutes($jamLatihan);

            $pembatalan = $totalHari > 0 || $totalJam >= 120 ? 'true' : 'false';
            $tglBuka    = Carbon::parse($jadwal->tanggal_kelas)->subDay()->setTime(19, 0);

            if ($role == 4) {
                return view('dashboard.pages.kelas.jadwal.join', compact('jadwal', 'daftar', 'pembatalan', 'tglBuka'));
            } else {
                return redirect()->route('jadwal.detail', $id);
            }
        }

        $response = DB::transaction(function () use ($request, $id) {
            // Mengunci jadwal yang sedang diproses
            $jadwal = Jadwal::where('id_jadwal', $id)->lockForUpdate()->first();
            $peserta = Peserta::where('jadwal_id', $id)->lockForUpdate()->get();

            // Memeriksa apakah kuota sudah penuh
            if ($peserta->count() >= $request->kuota) {
                return ['status' => 'failed', 'message' => 'Maaf kuota sudah penuh'];
            }

            // Memeriksa apakah pengguna sudah terdaftar
            $daftar = Peserta::where('member_id', Auth::user()->id)
                ->where('jadwal_id', $id)
                ->where('tanggal_latihan', $jadwal->tanggal_kelas)
                ->first();

            if (!$daftar) {
                $id_peserta = Peserta::withTrashed()->count();
                $tambah = new Peserta();
                $tambah->id_peserta = $id_peserta + 1;
                $tambah->jadwal_id = $id;
                $tambah->member_id = $request->member_id;
                $tambah->tanggal_latihan = $request->tanggal_latihan;
                $tambah->save();
                return ['status' => 'success', 'message' => 'Berhasil mendaftar kelas!'];
            } else {
                return ['status' => 'failed', 'message' => 'Anda sudah terdaftar dalam kelas ini.'];
            }
        });

        // Mengarahkan ke route jadwal.join dengan notifikasi yang sesuai
        return redirect()->route('jadwal.join', $id)->with($response['status'], $response['message']);
    }

    public function cancel(Request $request, $id)
    {
        Peserta::where('jadwal_id', $id)->where('member_id', $request->member_id)->delete();
        return redirect()->route('jadwal.join', $id)->with('success', 'Berhasil membatalkan kelas!');
    }

    public function attendance(Request $request, $id)
    {
        $peserta = $request->get('peserta');

        foreach ($peserta as $i => $id_peserta) {
            $kehadiran = $request->get('kehadiran');
            $status    = $request->get('status');
            $user      = Peserta::where('id_peserta', $id_peserta)->first();

            if ($kehadiran[$i] == 'true') {
                Peserta::where('id_peserta', $id_peserta)->update([
                    'kehadiran' => 'hadir'
                ]);
            } else {
                Peserta::where('id_peserta', $id_peserta)->update([
                    'kehadiran' => $status[$i]
                ]);

                $penalty = Penalty::where('user_id', $id_peserta)->where('status', 'false')->count();

                if ($status[$i] == 'alpha' && $penalty == 0) {
                    $tomorrow = Carbon::tomorrow();
                    Penalty::create([
                        'user_id' => $user->member_id,
                        'tgl_awal_penalty' => $tomorrow,
                        'tgl_akhir_penalty' => $tomorrow->copy()->addDays(7),
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        return redirect()->route('jadwal.detail', $id)->with('success', 'Berhasil melakukan Absensi!');
    }

    public function cancelJoin($id)
    {
        $peserta = Peserta::where('id_peserta', $id)->first();
        Peserta::where('id_peserta', $id)->delete();

        return redirect()->route('jadwal.detail', $peserta->jadwal_id)->with('success', 'Successfully Deleted');
    }

    public function updateKehadiran(Request $request, $id)
    {
        $peserta = Peserta::where('id_peserta', $id)->first();
        $jadwal  = Jadwal::where('id_jadwal', $peserta->jadwal_id)->first();

        if ($request->kehadiran == 'hadir') {
            Peserta::where('id_peserta', $id)->update([
                'kehadiran' => $request->kehadiran
            ]);
        } else {
            Peserta::where('id_peserta', $id)->update([
                'kehadiran' => $request->kehadiran
            ]);

            $penalty = Penalty::where('user_id', $id)->where('status', 'false')->count();

            if ($request->kehadiran == 'alpha' && $penalty == 0) {
                $tomorrow = Carbon::tomorrow();
                Penalty::create([
                    'jadwal_id' => $peserta->jadwal_id,
                    'user_id'  => $peserta->member_id,
                    'tgl_awal_penalty'  => $tomorrow,
                    'tgl_akhir_penalty' => $tomorrow->copy()->addDays(7),
                    'status' => 'false',
                    'created_at' => Carbon::now()
                ]);
            }
        }

        return redirect()->route('jadwal.detail', $peserta->jadwal_id)->with('success', 'Berhasil menyimpan perubahan!');
    }
}
