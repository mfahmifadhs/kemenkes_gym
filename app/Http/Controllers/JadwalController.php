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

        $jadwal     = Jadwal::select(DB::raw("DATE_FORMAT(tanggal_kelas, '%a') as hari"), 't_jadwal.*')
            ->where(DB::raw("DATE_FORMAT(tanggal_kelas, '%d-%b-%Y')"), $today)
            ->get();

        $daftar     = Peserta::where('member_id', Auth::user()->id)->first();
        return view('dashboard.pages.kelas.jadwal.show', compact('jadwal', 'range', 'rangeAwal', 'today', 'daftar'));
    }

    public function detail($id)
    {
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
        $jadwal     = Jadwal::select(DB::raw("DATE_FORMAT(tanggal_kelas, '%d-%b-%Y') as hari"), 't_jadwal.*')
            ->where(DB::raw("DATE_FORMAT(tanggal_kelas, '%d-%b-%Y')"), $id)
            ->get();

        $daftar     = Peserta::where('member_id', Auth::user()->id)->first();
        return view('dashboard.pages.kelas.jadwal.show', compact('jadwal', 'range', 'rangeAwal', 'today', 'daftar', 'status'));
    }

    public function create($id)
    {
        $role  = Auth::user()->role_id;
        $kelas = Kelas::where('id_kelas', $id)->first();

        if ($role == 1 || $role == 3) {
            return view('admin.pages.jadwal.create', compact('kelas'));
        } else {
            return view('dashboard.pages.kelas.jadwal.create', compact('kelas'));
        }
    }

    public function store(Request $request)
    {
        $cekHari = Jadwal::where('kelas_id', $request->kelas_id)->whereDate('tanggal_kelas', '=', date('Y-m-d', strtotime($request->tanggal)))->count();

        if ($cekHari != 0) {
            return redirect()->route('kelas.detail', $request->kelas_id)->with('failed', 'Jadwal sudah tersediaPlease Only Update the Date');
        }

        $tambah = new Jadwal();
        $tambah->kelas_id       = $request->kelas_id;
        $tambah->tanggal_kelas  = $request->tanggal;
        $tambah->waktu_mulai    = $request->waktu_mulai;
        $tambah->waktu_selesai  = $request->waktu_selesai;
        $tambah->kuota          = $request->kuota;
        $tambah->nama_pelatih   = $request->nama_pelatih;
        $tambah->lokasi         = $request->lokasi;
        $tambah->save();

        return redirect()->route('kelas.detail', $request->kelas_id)->with('success', 'Berhasil membuat jadwal!');
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
            'nama_pelatih'  => $request->nama_pelatih
        ]);

        return redirect()->route('kelas.detail', $request->kelas_id)->with('success', 'Berhasil memperbaharui jadwal!');
    }

    public function join(Request $request, $id)
    {
        $penalty = Penalty::where('user_id', Auth::user()->id)->where('status', 'false')->first();

        if ($penalty) {
            $tgl_awal = Carbon::now()->startOfDay();
            $tgl_akhir = Carbon::parse($penalty->tgl_akhir_penalty)->startOfDay();
            $total_hari = $tgl_awal->diffInDays($tgl_akhir, false);

            if ($total_hari == 0) {
                Penalty::where('id_penalty', $penalty->id_penalty)->update([
                    'status' => 'true'
                ]);
            }
        }

        if ($request->all() == []) {
            $jadwal  = Jadwal::where('id_jadwal', $id)->first();
            $daftar  = Peserta::where('member_id', Auth::user()->id)->where('jadwal_id', $id)->where('tanggal_latihan', $jadwal->tanggal_kelas)->first();

            $tglNow     = Carbon::now()->startOfDay();
            $tglLatihan = Carbon::parse($jadwal->tanggal_kelas)->startOfDay();
            $jamNow     = Carbon::now();
            $jamLatihan = Carbon::parse($jadwal->waktu_mulai);

            $totalHari  = $tglNow->diffInDays($tglLatihan, false);
            $totalJam   = $jamNow->diffInMinutes($jamLatihan);

            $pembatalan = $totalHari > 0 || $totalJam >= 120 ? 'true' : 'false';

            return view('dashboard.pages.kelas.jadwal.join', compact('jadwal', 'daftar', 'pembatalan'));
        }

        $peserta = Peserta::where('jadwal_id', $id)->get();

        if ($request->kuota == $peserta->count()) {
            return redirect()->route('jadwal.join', $id)->with('failed', 'Maaf kuota sudah penuh');
        };

        $id_peserta = Peserta::withTrashed()->count();
        $tambah = new Peserta();
        $tambah->id_peserta      = $id_peserta + 1;
        $tambah->jadwal_id       = $id;
        $tambah->member_id       = $request->member_id;
        $tambah->tanggal_latihan = $request->tanggal_latihan;
        $tambah->save();

        return redirect()->route('jadwal.join', $id)->with('success', 'Berhasil mendaftar kelas!');
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
                    'user_id' => $peserta->member_id,
                    'tgl_awal_penalty' => $tomorrow,
                    'tgl_akhir_penalty' => $tomorrow->copy()->addDays(7),
                    'status' => 'false',
                    'created_at' => Carbon::now()
                ]);
            }
        }

        return redirect()->route('jadwal.detail', $peserta->jadwal_id)->with('success', 'Berhasil menyimpan perubahan!');
    }
}
