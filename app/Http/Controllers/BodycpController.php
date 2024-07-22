<?php

namespace App\Http\Controllers;

use App\Models\Bodycp;
use Illuminate\Http\Request;
use Auth;

class BodycpController extends Controller
{
    public function show()
    {
        $user       = Auth::user();
        $dataBodycp = Bodycp::orderBy('id_bodycp', 'ASC');

        // format tanggal
        // $Carbon::createFromFormat('d/m/Y H:i', $bodycp->tanggal_cek)->isoFormat('DD MMMM Y HH:mm');

        if ($user->role_id != 4) {
        } else {
            $bodyCp = $dataBodycp->where('member_id', $user->id)->get();
            return view('dashboard.pages.bodycp.show', compact('bodyCp'));
        }
    }

    public function chart()
    {
        $result = Bodycp::select('weight', 'fatm as fat_mass', 'pmm as muscle_mass')
            ->where('member_id', Auth::user()->id)
            ->get();

        return response()->json($result);
    }
}
