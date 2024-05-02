<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
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
        return view('dashboard.pages.kelas.jadwal.show', compact('jadwal','range','rangeAwal','today','daftar'));
    }

    public function detail($id)
    {
        $jadwal = Jadwal::where('id_jadwal', $id)->first();

        if (Auth::user()->role_id == 1) {
            return view('admin.pages.jadwal.detail', compact('jadwal'));
        } else {
            return view('dashboard.pages.kelas.show', compact('jadwal'));
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
        return view('dashboard.pages.kelas.jadwal.show', compact('jadwal','range','rangeAwal','today', 'daftar', 'status'));
    }

    public function create($id)
    {
        $kelas = Kelas::where('id_kelas', $id)->first();

        if (Auth::user()->role_id == 1) {
            return view('admin.pages.jadwal.create', compact('kelas'));
        } else {
            return view('dashboard.pages.kelas.jadwal.create', compact('kelas'));
        }
    }

    public function store(Request $request)
    {
        $cekHari = Jadwal::where('kelas_id', $request->kelas_id)->whereDate('tanggal_kelas', '=', date('Y-m-d', strtotime($request->tanggal)))->count();

        if ($cekHari != 0) {
            return redirect()->route('kelas.detail', $request->kelas_id)->with('failed', 'Days Name Available, Please Only Update the Date');
        }

        $tambah = new Jadwal();
        $tambah->kelas_id       = $request->kelas_id;
        $tambah->tanggal_kelas  = $request->tanggal;
        $tambah->waktu_mulai    = $request->waktu_mulai;
        $tambah->waktu_selesai  = $request->waktu_selesai;
        $tambah->kuota          = $request->kuota;
        $tambah->nama_pelatih   = $request->nama_pelatih;
        $tambah->save();

        return redirect()->route('kelas.detail', $request->kelas_id)->with('success', 'Created Successfully!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::where('id_jadwal', $id)->first();

        if (Auth::user()->role_id == 1) {
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

        return redirect()->route('kelas.detail', $request->kelas_id)->with('success', 'Updated Successfully!');
    }

    public function join(Request $request, $id)
    {

        if ($request->all() == []) {
            $jadwal  = Jadwal::where('id_jadwal', $id)->first();
            $daftar  = Peserta::where('member_id', Auth::user()->id)->where('jadwal_id', $id)->where('tanggal_latihan', $jadwal->tanggal_kelas)->first();
            return view('dashboard.pages.kelas.jadwal.join', compact('jadwal','daftar'));
        }

        $id_peserta = Peserta::withTrashed()->count();
        $tambah = new Peserta();
        $tambah->id_peserta      = $id_peserta + 1;
        $tambah->jadwal_id       = $id;
        $tambah->member_id       = $request->member_id;
        $tambah->tanggal_latihan = $request->tanggal_latihan;
        $tambah->save();

        return redirect()->route('jadwal.join', $id)->with('success', 'Success Register!');
    }
}
