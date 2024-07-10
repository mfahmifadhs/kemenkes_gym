<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KonsulController extends Controller
{
    public function show()
    {
        return view('dashboard.pages.konsul.show');
    }
}
