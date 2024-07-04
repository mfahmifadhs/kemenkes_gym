<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SurveyController extends Controller
{
    public function show()
    {
        return view('survey');
    }

    public function store($id)
    {
        $kepuasan = $id == 'puas' ? 'puas' : 'tidak puas';

        $tambah = new Survey();
        $tambah->kepuasan = $kepuasan;
        $tambah->created_at = Carbon::now();
        $tambah->save();

        return redirect()->route('survey-kepuasan')->with('success', 'TERIMA KASIH, SALAM SEHAT !');
    }
}
