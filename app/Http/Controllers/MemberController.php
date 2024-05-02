<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MinatKelas;
use App\Models\MinatTarget;
use App\Models\Target;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use App\Models\LogMail;
use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Hash;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function show()
    {
        $searchCol1 = '';
        $searchInst = '';
        $searchUker = '';
        $searchNama = '';
        $searchNip  = '';
        $searchMail = '';
        $searchCol7 = '';

        $member = User::where('role_id', 4)->paginate(10);
        $uker   = User::select('uker_id', 'nama_unit_kerja')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->groupBy('uker_id', 'nama_unit_kerja')
            ->orderBy('nama_unit_kerja', 'ASC')
            ->get();

        return view('admin.pages.member.show', compact('member', 'uker', 'searchCol1', 'searchInst', 'searchUker', 'searchNama', 'searchNip', 'searchMail', 'searchCol7'));
    }

    public function search(Request $request)
    {
        $res = '';
        $perPage    = $request->get('perPage', 10);
        $searchCol1 = $request->get('col1'); // Member ID
        $searchInst = $request->get('searchInst'); // Tanggal
        $searchUker = $request->get('searchUker'); // Asal Unit Kerja
        $searchInst = $request->get('searchInst'); // Asal Instansi
        $searchNama = $request->get('searchNama'); // Nama
        $searchNip  = $request->get('searchNip'); // NIP NIK
        $searchMail = $request->get('searchMail'); // Email
        $searchCol7 = $request->get('col7'); // Telepon
        $data       = User::where('role_id', 4);
        $uker       = User::select('uker_id', 'nama_unit_kerja')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->groupBy('uker_id', 'nama_unit_kerja')
            ->orderBy('nama_unit_kerja', 'ASC')
            ->get();

        if ($searchCol1 || $searchInst || $searchUker || $searchNama || $searchNip || $searchMail || $searchCol7) {
            if ($searchCol1) {
                $res = $data->where('member_id', 'like', '%' . $searchCol1 . '%');
            }

            if ($searchInst) {
                $res = $data->where('instansi', 'like', '%' . $searchInst . '%');
            }

            if ($searchUker) {
                $res = $data->whereHas('uker', function ($query) use ($searchUker) {
                    $query->where('nama_unit_kerja', 'like', '%' . $searchUker . '%');
                })
                    ->orWhere('nama_instansi', 'like', '%' . $searchUker . '%');
            }

            if ($searchNama) {
                $res = $data->where('nama', 'like', '%' . $searchNama . '%');
            }

            if ($searchNip) {
                $res = $data->where('nip_nik', 'like', '%' . $searchNip . '%');
            }

            if ($searchMail) {
                $res = $data->where('email', 'like', '%' . $searchMail . '%');
            }

            if ($searchCol7) {
                $res = $data->where('no_telp', 'like', '%' . $searchCol7 . '%');
            }
        }

        $resArr = !$res ? $data : $res;

        $member = $resArr->paginate($perPage);

        $member->appends([
            'searchCol1' => $searchCol1,
            'searchInst' => $searchInst,
            'searchUker' => $searchUker,
            'searchNama' => $searchNama,
            'searchNip'  => $searchNip,
            'searchMail' => $searchMail,
            'searchCol7' => $searchCol7
        ]);

        return view('admin.pages.member.show', compact('member', 'uker', 'searchCol1', 'searchInst', 'searchUker', 'searchNama', 'searchNip', 'searchMail', 'searchCol7'));
    }

    public function searchBy($var, $id)
    {
        $searchCol1 = '';
        $searchInst = '';
        $searchUker = '';
        $searchNama = '';
        $searchNip  = '';
        $searchMail = '';
        $searchCol7 = '';

        $uker   = User::select('uker_id', 'nama_unit_kerja')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->groupBy('uker_id', 'nama_unit_kerja')
            ->orderBy('nama_unit_kerja', 'ASC')
            ->get();
        $data   = User::where('role_id', 4)->join('t_unit_kerja','id_unit_kerja','uker_id');

        if ($var == 'utama') {
            $member = $data->where('unit_utama_id', $id)->paginate('10');
        }

        return view('admin.pages.member.show', compact('member', 'uker', 'searchCol1', 'searchInst', 'searchUker', 'searchNama', 'searchNip', 'searchMail', 'searchCol7'));

    }

    public function detail($id)
    {
        $member = User::where('id', $id)->first();
        return view('admin.pages.member.detail', compact('member'));
    }

    public function edit($id)
    {
        $member = User::where('id', $id)->first();
        $utama  = UnitUtama::get();
        $uker   = UnitKerja::get();
        $kelas  = Kelas::get();
        $target = Target::get();

        if (Auth::user()->role_id == 1) {
            return view('admin.pages.member.edit', compact('member', 'utama', 'uker', 'kelas', 'target'));
        } else {
            return view('dashboard.pages.user.edit', compact('member', 'utama', 'uker', 'kelas', 'target'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!$request->kelas && !$request->target) {
            $tanggal_lahir    = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir);
            $tanggal_sekarang = Carbon::now();
            $usia = $tanggal_lahir->diffInYears($tanggal_sekarang);

            $totalUser = User::count();
            $idUser    = $totalUser + 1;

            User::where('id', $id)->update([
                'role_id'        => $request->role ?? 4,
                'uker_id'        => $request->instansi == 'pusat' ? $request->uker : null,
                'nip_nik'        => $request->nipnik,
                'nama'           => $request->nama,
                'jenis_kelamin'  => $request->jkelamin,
                'tempat_lahir'   => strtoupper($request->tempat_lahir),
                'tanggal_lahir'  => $request->tanggal_lahir,
                'usia'           => $usia,
                'no_telp'        => $request->no_telp,
                'instansi'       => $request->instansi,
                'nama_instansi'  => $request->instansi != 'pusat' ? $request->nama_instansi : null,
                'tinggi'         => $request->tinggi,
                'berat'          => $request->berat
            ]);


            if (Auth::user()->role_id == 1) {
                return redirect()->route('member.detail', $id)->with('success', 'Berhasil Menyimpan Perubahan');
            } else {
                return redirect()->route('profile', $id)->with('success', 'Berhasil Menyimpan Perubahan');
            }

        }

        // update kelas
        if ($request->kelas == 'true') {
            $kelasTerdaftar = MinatKelas::where('member_id', $id)->where('kelas_id', $request->kelas_update)->count();

            if ($kelasTerdaftar == 1 && $request->kelas_update != null) {
                return redirect()->route('member.edit', $id)->with('failed', 'Kelas sudah terdaftar');
            } else {
                if ($request->kelas_update_id != null) {
                    MinatKelas::where('id_minat_kelas', $request->kelas_update_id)->update([
                        'kelas_id' => $request->kelas_update
                    ]);
                } else {
                    $kelasAdd = new MinatKelas();
                    $kelasAdd->member_id = $id;
                    $kelasAdd->kelas_id = $request->kelas_update;
                    $kelasAdd->save();
                }

                return redirect()->route('member.edit', $id)->with('success', 'Berhasil Menyimpan Perubahan');
            }
        }

        // update target
        if ($request->target == 'true') {
            $targetTerdaftar = MinatTarget::where('member_id', $id)->where('target_id', $request->target_update)->count();

            if ($targetTerdaftar == 1 && $request->target_update != null) {
                return redirect()->route('member.edit', $id)->with('failed', 'Target sudah terdaftar');
            } else {
                if ($request->target_update_id != null) {
                    MinatTarget::where('id_minat_target', $request->target_update_id)->update([
                        'target_id' => $request->target_update
                    ]);
                } else {
                    $targetAdd = new MinatTarget();
                    $targetAdd->member_id = $id;
                    $targetAdd->target_id = $request->target_update;
                    $targetAdd->save();
                }

                return redirect()->route('member.edit', $id)->with('success', 'Berhasil Menyimpan Perubahan');
            }
        }
    }

    public function editPassword($id)
    {
        $member = User::where('id', $id)->first();


        if (Auth::user()->role_id == 1) {
            return view('admin.pages.member.password', compact('member'));
        } else {
            return view('dashboard.pages.user.password', compact('member'));
        }
    }

    public function updatePassword(Request $request, $id)
    {
        User::where('id',$id)->update([
            'password'       => Hash::make($request->password),
            'password_teks'  => $request->password
        ]);

        if (Auth::user()->role_id == 1) {
            return redirect()->route('member.detail', $id)->with('success', 'Update Password Successfully');
        } else {
            return redirect()->route('login')->with('success', 'Update Password Successfully');
        }
    }

    public function editEmail($id)
    {
        $member = User::where('id', $id)->first();

        if (Auth::user()->role_id == 1) {
            return view('admin.pages.member.email', compact('member'));
        } else {
            return view('dashboard.pages.user.email', compact('member'));
        }
    }

    public function updateEmail(Request $request, $id)
    {
        $emailTerdaftar = User::where('id', $id)->where('email', $request->email)->count();

        if ($emailTerdaftar == 1) {
            return redirect()->route('member.email', $id)->with('failed', 'Email sudah terdaftar');
        }

        if ($request->email) {
            User::where('id',$id)->update([
                'email' => $request->email
            ]);
        }

        if (Auth::user()->role_id == 1) {
            return redirect()->route('member.detail', $id)->with('success', 'Berhasil Mengubah Email');
        } else {
            return redirect()->route('profile', $id)->with('success', 'Update Success');
        }
    }

    public function resendEmail($id)
    {
        $user = User::where('id', $id)->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')->first();

        $tokenMail = Str::random(32);
        $logMail = new LogMail();
        $logMail->user_id = $id;
        $logMail->token   = $tokenMail;
        $logMail->save();

        $data = [
            'token'    => $tokenMail,
            'id'       => $id,
            'nama'     => $user->nama,
            'uker'     => $user->instansi == 'pusat' ? $user->nama_unit_kerja : $user->nama_instansi,
            'username' => $user->username
        ];

        Mail::to($user->email)->send(new SendEmail($data));
        return redirect()->route('member.email', $id)->with('success', 'Resend link Activation Success!');
    }


    public function delete($id)
    {
        $member = User::where('id', $id)->delete();
        return redirect()->route('member')->with('success', 'Berhasil Menghapus Data');
    }

    public function deleteMinat($id)
    {
        MinatKelas::where('id_minat_kelas', $id)->delete();
        return back()->with('success', 'Berhasil Menghapus Data');
    }

    public function chartAll()
    {
        $result = MinatKelas::join('t_kelas', 'id_kelas', 'kelas_id')
            ->select('nama_kelas', 'kelas_id', DB::raw('COUNT(member_id) as total_member'))
            ->groupBy('nama_kelas', 'kelas_id')
            ->orderBy('kelas_id')
            ->get();

        // Menampilkan hasil dalam format JSON
        return response()->json($result);
    }
}
