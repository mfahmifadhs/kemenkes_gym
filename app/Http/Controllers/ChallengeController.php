<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.challenge.show');
    }

    public function detail($id)
    {
        $judul = $id == 'fatloss' ? 'Fat Loss Challenge' : 'Muscle Gain Challenge';
        $foto  = $id == 'fatloss' ? 'https://cdn-icons-png.flaticon.com/128/3136/3136101.png' : 'https://cdn-icons-png.flaticon.com/128/10916/10916574.png';

        return view('dashboard.pages.challenge.detail', compact('id', 'judul', 'foto'));
    }
}
