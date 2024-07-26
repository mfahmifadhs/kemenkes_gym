<?php

namespace App\Http\Controllers;

use App\Models\Loker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    public function index()
    {
        $status = 'false';
        return view('loker', compact('status'));
    }

    public function check(Request $request, $status, $id) {
        $member = User::where('member_id', 'like', '%'.$id)->first();

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

        $tambah = new Loker();
        $tambah->member_id   = $id;
        $tambah->jenis_loker = $member->jenis_kelamin;
        $tambah->no_loker    = $loker;
        $tambah->created_at  = Carbon::now();
        $tambah->save();

        return response()->json(['success' => true]);
    }
}
