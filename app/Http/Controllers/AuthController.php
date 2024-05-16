<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use Illuminate\Http\Request;
use App\Mail\SendEmail;
use App\Models\Kelas;
use App\Models\LogMail;
use App\Models\MinatKelas;
use App\Models\MinatTarget;
use App\Models\Target;
use App\Models\User;
use Hash;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'password'  => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->isVerify == 'true' && auth()->user()->status == 'true') {
                return redirect()->intended('dashboard')->with('success', 'Hello!');
            } else {
                Session::flush();
                return redirect()->route('login')->with('failed', 'Account is not active.');
            }
        }

        return redirect()->route('login')->with('failed', 'Wrong Username or Password');
    }

    public function dashboard()
    {
        return redirect()->route('pages.dashboard')->with('success', 'Welcome');
    }

    public function daftar()
    {
        $kelas  = Kelas::orderBy('nama_kelas', 'ASC')->get();
        $target = Target::orderBy('nama_target', 'ASC')->get();
        $utama  = UnitUtama::get();
        return view('daftar', compact('utama','kelas','target'));
    }

    public function postDaftar(Request $request)
    {
        $cekUser   = User::where('username', $request->username)->count();
        $cekEmail  = User::where('email', $request->email)->count();
        $cekNipnik = User::where('nip_nik', $request->nipnik)->count();

        if ($cekUser == 1) {
            return back()->with('failed', 'Username Sudah Terdaftar');
        } else if ($cekEmail == 1) {
            return back()->with('failed', 'Email Sudah Terdaftar');
        } else if ($cekNipnik == 1) {
            return back()->with('failed', 'NIP/NIK Sudah Terdaftar');
        }

        $tanggal_lahir    = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir);
        $tanggal_sekarang = Carbon::now();
        $usia = $tanggal_lahir->diffInYears($tanggal_sekarang);

        $totalUser = User::withTrashed()->count();
        $idUser    = $totalUser + 1;

        $tambah = new User();
        $tambah->id             = $idUser;
        $tambah->role_id        = 4;
        $tambah->uker_id        = $request->instansi == 'pusat' ? $request->uker : null;
        $tambah->nip_nik        = $request->nipnik;
        $tambah->nama           = $request->nama;
        $tambah->jenis_kelamin  = $request->jkelamin;
        $tambah->tempat_lahir   = strtoupper($request->tempat_lahir);
        $tambah->tanggal_lahir  = $request->tanggal_lahir;
        $tambah->usia           = $usia;
        $tambah->instansi       = $request->instansi;
        $tambah->nama_instansi  = $request->instansi != 'pusat' ? $request->nama_instansi : null;
        $tambah->tinggi         = $request->tinggi;
        $tambah->berat          = $request->berat;
        $tambah->email          = $request->email;
        $tambah->username       = $request->username;
        $tambah->password       = Hash::make($request->password);
        $tambah->password_teks  = $request->password;
        $tambah->save();

        $kelas = $request->peminatan;
        foreach ($kelas as $kelas_id) {
            $kelasAdd = new MinatKelas();
            $kelasAdd->member_id = $idUser;
            $kelasAdd->kelas_id  = $kelas_id;
            $kelasAdd->save();
        }

        $target = $request->target;
        foreach ($target as $target_id) {
            $targetAdd = new MinatTarget();
            $targetAdd->member_id = $idUser;
            $targetAdd->target_id = $target_id;
            $targetAdd->save();
        }

        $uker = UnitKerja::where('id_unit_kerja', $request->uker)
                ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
                ->first();

        $tokenMail = Str::random(32);
        $logMail = new LogMail();
        $logMail->user_id = $idUser;
        $logMail->token   = $tokenMail;
        $logMail->save();

        $data = [
            'token'    => $tokenMail,
            'id'       => $idUser,
            'nama'     => $request->nama,
            'uker'     => $request->instansi == 'pusat' ? $uker->nama_unit_kerja : $request->nama_instansi,
            'username' => $request->username
        ];

        Mail::to($request->email)->send(new SendEmail($data));
        return redirect()->route('login')->with('success', 'Registration Success!, Please check you`re email for Activation');
    }

    public function aktivasi($token, $id)
    {
        $cekLogMail = LogMail::where('token', $token)->first();
        if ($cekLogMail->isExpired == 'true') {
            return redirect()->route('login')->with('failed', 'Token Expired');
        }

        $user     = User::where('id', $id)->first();
        $format   = Carbon::now()->isoFormat('YYMMDDHHmmss');
        $total    = str_pad($id, 4, 0, STR_PAD_LEFT);
        $rand     = rand(111,999);
        $memberId = $format.$rand.$total;

        User::where('id', $id)->update([
            'member_id'  => $user->member_id ?? $memberId,
            'isVerify'   => 'true',
            'status'     => 'true',
            'created_at' => Carbon::now()
        ]);

        LogMail::where('token', $token)->update([
            'isExpired' => 'true'
        ]);

        session()->forget('success');
        return redirect()->route('login')->with('success', 'Activation Success!');

    }

    public function resendActivation(Request $request)
    {
        $user = User::where('email', $request->email)->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')->first();

        if (!$user) {
            return back()->with('failed', 'Account not found!');
        }

        if ($user->member_id != null) {
            return back()->with('failed', 'You`re Account is Active!');
        }

        $tokenMail = Str::random(32);
        $logMail = new LogMail();
        $logMail->user_id = $user->id;
        $logMail->token   = $tokenMail;
        $logMail->save();

        $data = [
            'token'    => $tokenMail,
            'id'       => $user->id,
            'nama'     => $user->nama,
            'uker'     => $user->instansi == 'pusat' ? $user->nama_unit_kerja : $user->nama_instansi,
            'username' => $user->username
        ];

        Mail::to($user->email)->send(new SendEmail($data));
        return redirect()->route('login')->with('success', 'Resend link Activation Success!');
    }

    public function sentMailResetPass(Request $request)
    {
        $user = User::where('email', $request->get('email'))->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')->first();

        if (!$user) {
            return back()->with('failed', 'Email belum terdaftar');
        }

        $tokenMail = Str::random(32);
        $data = [
            'token'    => $tokenMail,
            'id'       => $user->id,
            'nama'     => $user->nama,
            'uker'     => $user->instansi == 'pusat' ? $user->nama_unit_kerja : $user->nama_instansi,
            'username' => $user->username,
            'password' => $user->password_teks
        ];

        Mail::to($user->email)->send(new ForgotPassword($data));
        return redirect()->route('login')->with('success', 'Berhasil mengirim link reset password');
    }

    public function showResetPass($token, $id)
    {
        dd($id);
    }


    public function keluar()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/')->with('success', 'Sign Out Success');
    }
}
