<?php

namespace App\Http\Controllers;

use App\Models\MinatKelas;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalPeminatan = MinatKelas::count();
        return view('welcome', compact('totalPeminatan'));
    }
}
