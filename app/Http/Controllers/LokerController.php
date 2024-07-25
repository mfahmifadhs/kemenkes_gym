<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
