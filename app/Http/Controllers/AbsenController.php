<?php

namespace App\Http\Controllers;

use App\Exports\AbsenExport;
use App\Models\Absensi;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AbsenController extends Controller
{
    public function show()
    {
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
            $absen = $query
                ->where(DB::raw("DATE_FORMAT(tanggal, '%d')"), $colDate)
                ->where(DB::raw("DATE_FORMAT(tanggal, '%m')"), $colMonth)
                ->where(DB::raw("DATE_FORMAT(tanggal, '%Y')"), $colYear)
                ->where('user_id', Auth::user()->id)
                ->paginate(10);
            return view('admin.pages.absen.show', compact('absen', 'colDate', 'colMonth', 'colYear', 'utama', 'uker', 'colUtama', 'colUker'));
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
            $absen = $res->paginate($perPage);
            return view('admin.pages.absen.show', compact('absen', 'colDate', 'colMonth', 'colYear', 'colUtama', 'colUker', 'utama', 'uker'));
        }
    }

    public function store(Request $request, $id)
    {
        $user  = User::where('member_id', $id)->first();
        $absen = Absensi::where('user_id', $user->id)->where('waktu_keluar', null)->first();

        if ($absen) {
            // Absensi::where('id_absensi', $absen->id_absensi)->update([
            //     'waktu_keluar' => Carbon::now()
            // ]);


            return response()->json(['hadir' => true]);
        } else {
            $tambah = new Absensi();
            $tambah->user_id = $user->id;
            $tambah->tanggal = Carbon::now();
            $tambah->waktu_masuk = Carbon::now();
            $tambah->created_at  = Carbon::now();
            $tambah->save();


            return response()->json(['success' => true]);
        }
    }

    public function update(Request $request, $id)
    {
        Absensi::where('id_absensi', $id)->update([
            'waktu_masuk'  => $request->masuk,
            'waktu_keluar' => $request->keluar
        ]);

        return redirect()->route('attendance.show')->with('success', 'Successfully Updated');
    }

    public function delete($id)
    {
        Absensi::where('id_absensi', $id)->delete();

        return redirect()->route('attendance.show')->with('success', 'Successfully Deleted');
    }

    public function report()
    {
        $listTopMember = Absensi::join('users', 'id', 'user_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
            ->select('id', 'nama', 'nama_unit_kerja', DB::raw('COUNT(id_absensi) as total_absen'))
            ->groupBy('id', 'nama', 'nama_unit_kerja')
            ->orderBy('total_absen', 'DESC')
            ->take(8)
            ->get();

        return view('admin.pages.absen.report', compact('listTopMember'));
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
}
