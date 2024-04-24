<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BodyckController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProgresController;
use App\Http\Controllers\UkerController;
use App\Http\Controllers\UserController;
use App\Models\Kelas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('/');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('uker/select/{id}', [UkerController::class, 'selectUker']);
Route::get('registration', [AuthController::class, 'daftar'])->name('daftar');
Route::get('aktivation/{token}/{id}', [AuthController::class, 'aktivasi'])->name('aktivasi');
Route::get('member/chart', [MemberController::class, 'chartAll'])->name('member.chart');
Route::get('logout', [AuthController::class, 'keluar'])->name('logout');

Route::post('registration', [AuthController::class, 'postDaftar'])->name('daftar');
Route::post('login', [AuthController::class, 'postLogin'])->name('masuk');


Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('waktu', [DashboardController::class, 'time'])->name('dashboard.time');

    Route::get('profile/{id}', [UserController::class, 'detail'])->name('profile');

    Route::get('member', [MemberController::class, 'show'])->name('member');
    Route::get('member/search', [MemberController::class, 'search'])->name('member.search');
    Route::get('member/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
    Route::get('member/password/{id}', [MemberController::class, 'editPassword'])->name('member.password');
    Route::get('member/email/{id}', [MemberController::class, 'editEmail'])->name('member.email');

    Route::get('member/detail/{id}', [MemberController::class, 'detail'])->name('member.detail');
    Route::get('member/delete/{id}', [MemberController::class, 'delete'])->name('member.delete');
    Route::post('member/update/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::post('member/update/password/{id}', [MemberController::class, 'updatePassword'])->name('member.updatePassword');
    Route::post('member/update/email/{id}', [MemberController::class, 'updateEmail'])->name('member.updateEmail');
    Route::get('member/resend/email/{id}', [MemberController::class, 'resendEmail'])->name('member.resendMail');

    Route::get('user', [UserController::class, 'show'])->name('user');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');

    Route::get('class', [KelasController::class, 'show'])->name('kelas');
    Route::get('class/detail/{id}', [KelasController::class, 'detail'])->name('kelas.detail');

    Route::get('class/schedule', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::get('class/schedule/cari/{id}', [JadwalController::class, 'filter'])->name('jadwal.pilih');
    Route::get('class/schedule/join/{id}', [JadwalController::class, 'join'])->name('jadwal.join');
    Route::get('class/create/schedule/{id}', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::get('class/edit/schedule/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::post('class/store/schedule', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('class/update/schedule/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::post('class/schedule/join/{id}', [JadwalController::class, 'join'])->name('jadwal.join');

    Route::get('bodyck', [BodyckController::class, 'show'])->name('bodyck');
    Route::get('bodyck/detail/{id}', [BodyckController::class, 'detail'])->name('bodyck.detail');
    Route::get('bodyck/edit/{id}', [BodyckController::class, 'edit'])->name('bodyck.edit');
    Route::get('bodyck/create', [BodyckController::class, 'create'])->name('bodyck.create');
    Route::post('bodyck/store', [BodyckController::class, 'create'])->name('bodyck.store');
    Route::post('bodyck/update/{id}', [BodyckController::class, 'edit'])->name('bodyck.update');


    Route::get('progress', [ProgresController::class, 'show'])->name('progres');
    Route::get('progress/chart', [ProgresController::class, 'chart'])->name('progres.chart');

});
