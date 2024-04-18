<?php

namespace App\Http\Controllers;

use App\Models\Bodyck;
use App\Models\BodyckDetail;
use App\Models\BodyckParam;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class ProgresController extends Controller
{
    public function show()
    {
        $bodyck = Bodyck::where('member_id', Auth::user()->id)->get();

        if (!$bodyck) {
            $bodyck = '';
        }

        return view('dashboard.pages.bodyck.progres.show', compact('bodyck'));
    }

    public function chart()
    {
        $param = BodyckDetail::select('bodyck_id')
                ->join('t_bodyck', 'id_bodyck', 'bodyck_id')
                ->where('member_id', Auth::user()->id)
                ->groupBy('bodyck_id')
                ->get();

        $chartRes = []; // Inisialisasi array untuk menyimpan data untuk grafik

        foreach ($param as $key => $value) {
            // Mengambil data untuk param_id = 1 (misalnya, weight)
            $weight = BodyckDetail::join('t_bodyck_param', 'id_param', 'param_id')
                ->select('nilai')
                ->where('bodyck_id', $value->bodyck_id)
                ->where('param_id', 1)
                ->first();

            // Mengambil data untuk param_id = 3 (misalnya, fat mass)
            $fatMass = BodyckDetail::join('t_bodyck_param', 'id_param', 'param_id')
                ->select('nilai')
                ->where('bodyck_id', $value->bodyck_id)
                ->where('param_id', 3)
                ->first();

            $muscleMass = BodyckDetail::join('t_bodyck_param', 'id_param', 'param_id')
                ->select('nilai')
                ->where('bodyck_id', $value->bodyck_id)
                ->where('param_id', 5)
                ->first();

            // Menyimpan data ke dalam array $chartRes
            $result[++$key] = [
                'bodyck_id'   => $value->bodyck_id,
                'weight'      => $weight ? $weight->nilai : 0,
                'fat_mass'    => $fatMass ? $fatMass->nilai : 0,
                'muscle_mass' => $muscleMass ? $muscleMass->nilai : 0
            ];
        }

        // Menampilkan hasil dalam format JSON
        // $result = json_encode($chartRes);
        return response()->json($result);
    }
}
