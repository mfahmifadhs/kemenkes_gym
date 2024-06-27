<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use Auth;

class FaqController extends Controller
{
    public function show()
    {
        $role = Auth::user()->role_id;
        $faq  = Component::where('kategori', 'faq')->first();

        if ($role == 1 || $role == 3) {
            return view('admin.pages.faq.show', compact('faq'));
        } else {
            return view('dashboard.pages.faq.show', compact('faq'));
        }
    }

    public function store(Request $request)
    {
        $judul      = $request->get('judul');
        $deskripsi  = $request->get('deskripsi');

        $faq = Component::where('kategori', 'faq')->first();

        if ($faq) {
            Component::where('id_component', $faq->id_component)->update([
                'judul'     => $judul,
                'deskripsi' => $deskripsi
            ]);
        } else {
            $addFaq = new Component();
            $addFaq->kategori  = 'faq';
            $addFaq->judul     = $judul;
            $addFaq->deskripsi = $deskripsi;
            $addFaq->save();
        }

        return redirect()->route('faq')->with('success', 'Berhasil menyimpan perubahan');
    }
}
