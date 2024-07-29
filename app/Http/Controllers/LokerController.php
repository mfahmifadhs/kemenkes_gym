<?php

namespace App\Http\Controllers;

use App\Models\Loker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class LokerController extends Controller
{
    public function index()
    {
        $status = 'false';
        return view('loker', compact('status'));
    }

    public function check(Request $request, $status, $id)
    {
        $member = User::where('member_id', 'like', '%' . $id)->first();

        if ($status == 'true') {
            return view('loker', compact('member', 'status'));
        }

        if (!$member) {
            return response()->json(['success' => false]);
        } else

            return response()->json(['success' => true]);
    }

    public function store($id, $loker)
    {
        $member = User::where('id', $id)->first();

        $lokerPakai  = Loker::where('waktu_kembali', null)->where('member_id', $id)->count();
        $lokerPenuh  = Loker::where('waktu_kembali', null)->where('no_loker', $loker)
            ->where('jenis_loker', $member->jenis_kelamin)->count();

        if ($lokerPakai == 1) {
            return response()->json(['ongoing' => true]);
        }

        if ($lokerPenuh == 1) {
            return response()->json(['full' => true]);
        }

        $tambah = new Loker();
        $tambah->member_id   = $id;
        $tambah->jenis_loker = $member->jenis_kelamin;
        $tambah->no_loker    = $loker;
        $tambah->created_at  = Carbon::now();
        $tambah->save();

        return response()->json(['success' => true]);
    }

    public function show()
    {
        $lokerToday = Loker::orderBy('created_at', 'DESC')
            ->where(DB::raw("DATE_FORMAT(created_at, '%d%m%y')"), Carbon::now()->format('dmy'))
            ->get();


        return view('admin.pages.loker.show', compact('lokerToday'));
    }
}
