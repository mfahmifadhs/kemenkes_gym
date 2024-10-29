<?php

namespace App\Http\Controllers;

use App\Exports\AbsenExport;
use App\Models\Absensi;
use App\Models\Peserta;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AbsenController extends Controller
{
    public function show()
    {
        $bkpk     = Auth::user()->uker->unit_utama_id == 46591 ? true : false;
        $role     = Auth::user()->role_id;
        $colDate  = Carbon::now()->format('d');
        $colMonth = Carbon::now()->format('m');
        $colYear  = Carbon::now()->format('Y');
        $utama    = UnitUtama::get();
        $uker     = UnitKerja::orderBy('nama_unit_kerja', 'ASC')->get();
        $colUtama = '';
        $colUker  = '';

        $query    = Absensi::orderBy('id_absensi', 'DESC');

        if ($role == 1 || $role == 3) {
            $data = $query
                ->where(DB::raw("DATE_FORMAT(tanggal, '%d')"), $colDate)
                ->where(DB::raw("DATE_FORMAT(tanggal, '%m')"), $colMonth)
                ->where(DB::raw("DATE_FORMAT(tanggal, '%Y')"), $colYear);

            if ($bkpk) {
                $absen = $data->where('lokasi_id', 2)->get();
            } else {
                $absen = $data->get();
            }

            return view('admin.pages.absen.show', compact('absen', 'colDate', 'colMonth', 'colYear', 'utama', 'uker', 'colUtama', 'colUker', 'bkpk'));
        } else if ($role == 4) {
            $absen = $query->where('user_id', Auth::user()->id)->paginate(10);
            return view('dashboard.pages.absen.show', compact('absen', 'colDate', 'colMonth', 'colYear'));
        } else {
            $absen = $query->paginate(10);
            return view('admin.pages.absen.show', compact('absen', 'colDate', 'colMonth', 'colYear', 'utama', 'uker', 'colUtama', 'colUker'));
        }
    }

    public function filter(Request $request)
    {
        $bkpk     = Auth::user()->uker->unit_utama_id == 46591 ? true : false;
        $perPage  = $request->get('perPage', 10);
        $colDate  = $request->get('tanggal');
        $colMonth = $request->get('bulan');
        $colYear  = $request->get('tahun');
        $colUtama = $request->get('utama');
        $colUker  = $request->get('uker');
        $utama    = UnitUtama::get();
        $uker     = UnitKerja::orderBy('nama_unit_kerja', 'ASC')->get();

        $data     = Absensi::orderBy('id_absensi', 'DESC')->join('users', 'id', 'user_id')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id');

        if ($colDate || $colMonth || $colYear || $colUker || $colUtama) {
            if ($colDate) {
                $res  = $data->where(DB::raw("DATE_FORMAT(tanggal, '%d')"), $colDate);
            }

            if ($colMonth) {
                $res  = $data->where(DB::raw("DATE_FORMAT(tanggal, '%m')"), $colMonth);
            }

            if ($colYear) {
                $res  = $data->where(DB::raw("DATE_FORMAT(tanggal, '%Y')"), $colYear);
            }

            if ($colUtama) {
                $res  = $data->where('unit_utama_id', $colUtama);
            }

            if ($colUker) {
                $res  = $data->where('uker_id', $colUker);
            }
        } else {
            $res    = $data;
        }

        if ($request->downloadFile == 'pdf') {
            $absen = $res->get();
            return view('admin.pages.absen.print', compact('absen'));
        } elseif ($request->downloadFile == 'excel') {
            return Excel::download(new AbsenExport($request->all()), 'show.xlsx');
        }

        if (Auth::user()->id == 4) {
            $absen = $res->where('user_id', Auth::user()->id)->paginate($perPage);
            return view('dashboard.pages.absen.show', compact('absen', 'colDate', 'colMonth', 'colYear', 'colUtama', 'colUker'));
        } else {

            if ($bkpk) {
                $absen = $res->where('lokasi_id', 2)->get();
            } else {
                $absen = $res->where('lokasi_id', 1)->get();
            }

            return view('admin.pages.absen.show', compact('absen', 'colDate', 'colMonth', 'colYear', 'colUtama', 'colUker', 'utama', 'uker', 'bkpk'));
        }
    }

    public function store(Request $request, $lokasi, $id)
    {
        $lokasi  = $lokasi == 'PUSAT' ? 1 : 2;
        $today   = Carbon::now()->toDateString();
        $timeNow = Carbon::now()->format('H:i:s');
        $user    = User::where('member_id', $id)->first();
        $absen   = Absensi::where('tanggal', $today)->where('user_id', $user->id)->orderBy('id_absensi', 'desc')->first();
        $jadwal  = '';

        $classNow = Peserta::join('t_jadwal', 'id_jadwal', '=', 'jadwal_id')
            ->where('tanggal_latihan', $today)
            ->where('kehadiran', null)
            ->where('member_id', $user->id)
            ->orderBy('waktu_mulai', 'ASC')
            ->first();

        if ($classNow) {
            if ($classNow->waktu_mulai == '06:15:00') {
                if ($timeNow >= '05:30') {
                    Peserta::where('id_peserta', $classNow->id_peserta)->update([
                        'kehadiran' => 'hadir'
                    ]);

                    $jadwal = $classNow ? $classNow->jadwal_id : null;
                } else {
                    $jadwal = null;
                }
            } else {
                if ($timeNow >= '15:00') {
                    Peserta::where('id_peserta', $classNow->id_peserta)->update([
                        'kehadiran' => 'hadir'
                    ]);

                    $jadwal = $classNow ? $classNow->jadwal_id : null;
                } else {
                    $jadwal = null;
                }
            }
        } else {
            $jadwal = null;
        }

        if ($absen) {
            if (Carbon::now()->diffInMinutes(Carbon::parse($absen->waktu_masuk)) < 30) {
                return response()->json(['hadir' => true]);
            }
        }

        $tambah = new Absensi();
        $tambah->lokasi_id = $lokasi;
        $tambah->jadwal_id = $jadwal;
        $tambah->user_id = $user->id;
        $tambah->tanggal = Carbon::now();
        $tambah->waktu_masuk = Carbon::now();
        $tambah->waktu_keluar = Carbon::now()->addHours(3);
        $tambah->created_at  = Carbon::now();
        $tambah->save();


        return response()->json(['success' => true]);

        // if ($absen) {
        //     Absensi::where('id_absensi', $absen->id_absensi)->update([
        //         'waktu_keluar' => Carbon::now()
        //     ]);
        //     return response()->json(['hadir' => true]);
        // } else {
        //     Kondisi tambah kehadiran
        // }
    }

    public function update(Request $request, $id)
    {
        Absensi::where('id_absensi', $id)->update([
            'waktu_masuk'  => $request->masuk,
            'waktu_keluar' => $request->keluar
        ]);

        return redirect()->route('absen.show')->with('success', 'Successfully Updated');
    }

    public function mobile($kelas)
    {
        $tambah = new Absensi();
        $tambah->jadwal_id    = $kelas;
        $tambah->user_id      = Auth::user()->id;
        $tambah->tanggal      = Carbon::now();
        $tambah->waktu_masuk  = Carbon::now();
        $tambah->waktu_keluar = Carbon::now()->addHours(3);
        $tambah->created_at   = Carbon::now();
        $tambah->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil Absensi Kelas!');
    }

    public function delete($id)
    {
        Absensi::where('id_absensi', $id)->delete();

        return redirect()->route('absen.show')->with('success', 'Successfully Deleted');
    }

    public function report()
    {
        $total = Absensi::count();
        $listTopMember = Absensi::join('users', 'id', 'user_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
            ->select('id', 'nama', 'nama_unit_kerja', DB::raw('COUNT(id_absensi) as total_absen'))
            ->groupBy('id', 'nama', 'nama_unit_kerja')
            ->orderBy('total_absen', 'DESC')
            ->take(8)
            ->get();

        $reportUtama = Absensi::join('users', 'id', 'user_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
            ->select(DB::RAW('count(id_absensi) as total'), 'nama_unit_utama')
            ->groupBy('id_unit_utama', 'nama_unit_utama')
            ->orderBy('total', 'DESC')
            ->get();

        $reportUker = Absensi::join('users', 'id', 'user_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->select(DB::RAW('count(id_absensi) as total'), 'nama_unit_kerja')
            ->groupBy('id_unit_kerja', 'nama_unit_kerja')
            ->orderBy('total', 'DESC')
            ->get();

        return view('admin.pages.absen.report', compact('total', 'listTopMember', 'reportUtama', 'reportUker'));
    }

    public function checkout($id)
    {
        $absen = Absensi::where('user_id', $id)->where('waktu_keluar', null)->first();

        Absensi::where('id_absensi', $absen->id_absensi)->update([
            'waktu_keluar' => Carbon::now()
        ]);


        return redirect()->route('survey.show', $absen->id_absensi)->with('success', 'Thank You!');
    }

    public function survey(Request $request, $id)
    {
        Absensi::where('id_absensi', $id)->update([
            'kepuasan'      => $request->result,
            'masukan'       => $request->masukan
        ]);

        return redirect()->route('dashboard')->with('success', 'Terima kasih');
    }

    public function chart()
    {
        $result = Absensi::select('tanggal', DB::raw('COUNT(tanggal) as total_absen'))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return response()->json($result);
    }

    public function list(Request $request)
    {
        $lokasi = $request->lokasi;
        $today  = Carbon::today();
        $data   = Absensi::with(['member', 'member.uker', 'jadwal.kelas'])
            ->whereDate('tanggal', $today)
            ->orderBy('waktu_masuk', 'DESC');

        if ($lokasi == 'BKPK') {
            dd('false');
            $absens = $data->where('lokasi_id', 2)->get();
        } else {
            dd('true');
            $absens = $data->where('lokasi_id', '!=', 2)->get();
        }

        return response()->json($absens);
    }
}
