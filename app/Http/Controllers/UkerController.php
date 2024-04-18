<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UkerController extends Controller
{
    public function selectUker($id)
    {
        $data = UnitKerja::where('unit_utama_id', $id)->orderBy('nama_unit_kerja', 'ASC')->get();
        $response = array();

        $response[] = array(
            "id"    => "",
            "text"  => "-- Pilih Unit Kerja --"
        );

        foreach($data as $row){
            $response[] = array(
                "id"    =>  $row->id_unit_kerja,
                "text"  =>  $row->nama_unit_kerja
            );
        }

        return response()->json($response);
    }
}
