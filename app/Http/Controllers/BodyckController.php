<?php

namespace App\Http\Controllers;

use App\Models\Bodyck;
use App\Models\BodyckDetail;
use App\Models\BodyckParam;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class BodyckController extends Controller
{
    public function show()
    {
        $role = Auth::user()->role_id;
        $data = Bodyck::orderBy('tanggal_cek', 'DESC');

        if ($role == 1 || $role == 2) {
            $bodyck = $data->get();
            return view('admin.pages.bodyck.show', compact('bodyck'));
        }

        $bodyck = $data->where('member_id', Auth::user()->id)->get();
        return view('dashboard.pages.bodyck.show', compact('bodyck'));
    }

    public function detail($id)
    {
        $role = Auth::user()->role_id;
        $bodyck = Bodyck::where('id_bodyck', $id)->first();

        if ($role == 1 || $role == 2) {
            return view('admin.pages.bodyck.detail', compact('bodyck'));
        }

        return view('dashboard.pages.bodyck.detail', compact('bodyck'));
    }

    public function create(Request $request)
    {
        if (!$request->all()) {
            $param = BodyckParam::get();
            return view('dashboard.pages.bodyck.create', compact('param'));
        }

        $totalBodyck = Bodyck::withTrashed()->count();
        $id_bodyck   = $totalBodyck + 1;

        $bodyck = new Bodyck();
        $bodyck->id_bodyck     = $id_bodyck;
        $bodyck->member_id     = Auth::user()->id;
        $bodyck->tanggal_cek   = Carbon::parse($request->tanggal)->isoFormat('Y-MM-DD H:m');
        $bodyck->no_serial     = $request->no_serial;
        $bodyck->tipe_badan    = $request->tipe_badan;
        $bodyck->bodyck_tinggi = $request->bodyck_tinggi;
        $bodyck->berat_baju    = $request->berat_baju;
        $bodyck->save();

        $id = $request->key;
        foreach ($id as $i => $param_id) {
            $totalDetail = BodyckDetail::withTrashed()->count();
            $val     = "val_" . ($i + 1);

            $detail = new BodyckDetail();
            $detail->id_detail = $totalDetail + 1;
            $detail->bodyck_id = $id_bodyck;
            $detail->param_id  = $param_id;
            $detail->nilai     = $request->$val;
            $detail->save();
        }

        return redirect()->route('bodyck.detail', $id_bodyck)->with('success', 'Berhasil menambah Body Composition!');
    }

    public function edit(Request $request, $id)
    {
        // dd($request->all());
        if (!$request->all()) {
            $bodyck = Bodyck::where('id_bodyck', $id)->first();
            $param  = BodyckParam::get();
            return view('dashboard.pages.bodyck.edit', compact('bodyck','param'));
        }

        Bodyck::where('id_bodyck', $id)->update([
            'id_bodyck'     => $id,
            'member_id'     => Auth::user()->id,
            'tanggal_cek'   => Carbon::parse($request->tanggal)->isoFormat('Y-MM-DD H:m'),
            'no_serial'     => $request->no_serial,
            'tipe_badan'    => $request->tipe_badan,
            'bodyck_tinggi' => $request->bodyck_tinggi,
            'berat_baju'    => $request->berat_baju
        ]);

        $id = $request->key;
        foreach ($id as $i => $param_id) {
            $val     = "val_" . ($param_id);

            BodyckDetail::where('id_detail', $request->id_detail[$i])->update([
                'nilai'     => $request->$val,
            ]);

            return redirect()->route('bodyck.detail', $id)->with('success', 'Berhasil menyimpan perubahan!');
        }
    }
}
