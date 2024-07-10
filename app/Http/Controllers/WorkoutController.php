<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Auth;

class WorkoutController extends Controller
{
    public function show()
    {
        $role = Auth::user()->role_id;
        $kelas = Peserta::where('member_id', Auth::user()->id)
            ->orderBy('tanggal_latihan', 'DESC')
            ->get();

        return view('dashboard.pages.workout.show', compact('kelas'));
    }
}
