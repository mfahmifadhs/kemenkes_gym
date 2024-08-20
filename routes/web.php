<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BodyckController;
use App\Http\Controllers\BodycpController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KonsulController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ProgresController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UkerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use App\Models\Kelas;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/activation', function () {
    return view('activation');
})->name('activation.show');

Route::get('/mail/reset/password', function () {
    return view('forgot-password.link');
})->name('mailResetPass.show');

Route::get('/Attendance', function () {
    return view('absensi');
})->name('attendance.show');

Route::get('/menu-tab', function () {
    return view('menu-tab');
})->name('menu.tab');



Route::post('absensi/post/{id}', [AbsenController::class, 'store']);
Route::post('Attendance/list', [AbsenController::class, 'list'])->name('absen.list');

Route::post('activation/post', [AuthController::class, 'resendActivation'])->name('activation.post');

Route::get('reset/password/email', [AuthController::class, 'sentMailResetPass'])->name('resetPass.mail');
Route::get('reset/password/{token}/{id}', [AuthController::class, 'showResetPass'])->name('resetPass.show');
Route::post('reset/password/{id}', [AuthController::class, 'postResetPass'])->name('resetPass.post');

Route::get('uker/select/{id}', [UkerController::class, 'selectUker']);
Route::get('registration', [AuthController::class, 'daftar'])->name('daftar');
Route::get('aktivation/{token}/{id}', [AuthController::class, 'aktivasi'])->name('aktivasi');

Route::get('member/chart', [MemberController::class, 'chartAll'])->name('member.chart');

Route::post('registration', [AuthController::class, 'postDaftar'])->name('daftar');
Route::post('login', [AuthController::class, 'postLogin'])->name('masuk');
Route::get('logout', [AuthController::class, 'keluar'])->name('logout');

Route::get('survey-kepuasan', [SurveyController::class, 'show'])->name('survey-kepuasan');
Route::get('survey-kepuasan/store/{id}', [SurveyController::class, 'store'])->name('survey-kepuasan.store');


Route::get('loker', [LokerController::class, 'index'])->name('loker');
Route::get('loker/{status}/{id}', [LokerController::class, 'check'])->name('loker.check');
Route::post('loker/{status}/{id}', [LokerController::class, 'check'])->name('loker.check');
Route::post('loker/post/{memberId}/{noLoker}', [LokerController::class, 'store'])->name('loker.store');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/leaderboard', function () {
        return redirect()->route('dashboard');
    })->name('leaderboard');

    Route::get('loker/daftar', [LokerController::class, 'show'])->name('loker.show');
    Route::get('loker/detail/{ctg}/{id}', [LokerController::class, 'detail'])->name('loker.no.detail');
    Route::get('loker/riwayat/delete/{id}', [LokerController::class, 'delete'])->name('loker.riwayat.delete');

    Route::get('challenge', [ChallengeController::class, 'index'])->name('challenge');
    Route::get('challenge/leaderboard', [ChallengeController::class, 'leaderboard'])->name('challenge.leaderboard');
    Route::get('challenge/leaderboard/filter', [ChallengeController::class, 'leaderboardFilter'])->name('challenge.leaderboard.filter');
    Route::get('challenge/leaderboard/update/{id}', [ChallengeController::class, 'leaderboardUpdate'])->name('challenge.leaderboard.update');
    Route::get('challenge/leaderboard/delete/{id}', [ChallengeController::class, 'leaderboardDelete'])->name('challenge.leaderboard.delete');
    Route::get('challenge/{id}', [ChallengeController::class, 'detail'])->name('challenge.detail');
    Route::get('challenge/join/{id}', [ChallengeController::class, 'join'])->name('challenge.join');
    Route::get('challenge/ticket/{id}', [ChallengeController::class, 'ticket'])->name('challenge.ticket');
    Route::get('challenge/download/{id}/{form}', [ChallengeController::class, 'download'])->name('challenge.download');
    Route::get('challenge/participant/filter', [ChallengeController::class, 'filter'])->name('challenge.participant.filter');
    Route::get('challenge/participant/store', [ChallengeController::class, 'participantStore'])->name('challenge.participant.store');
    Route::get('challenge/participant/detail/{id}', [ChallengeController::class, 'participantDetail'])->name('challenge.participant.detail');
    Route::get('challenge/participant/tanita-delete/{id}', [ChallengeController::class, 'tanitaDelete'])->name('challenge.tanita.delete');
    Route::get('challenge/participant/delete/{id}', [ChallengeController::class, 'participantDelete'])->name('challenge.participant.delete');
    Route::get('challenge/participant/update/{id}', [ChallengeController::class, 'participantUpdate'])->name('challenge.participant.update');

    Route::get('kehadiran/{kelas}', [AbsenController::class, 'mobile']);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('waktu', [DashboardController::class, 'time'])->name('dashboard.time');
    Route::get('profile/{id}', [UserController::class, 'detail'])->name('profile');

    Route::get('absen/checkout/{id}', [AbsenController::class, 'checkout'])->name('absen.checkout');
    Route::get('absen/list', [AbsenController::class, 'show'])->name('absen.show');

    Route::get('/absen/checkout/survey/{id}', function ($id) {
        return view('dashboard.survey', ['id' => $id]);
    })->name('survey.show');

    Route::post('absen/checkout/survey/{id}', [AbsenController::class, 'survey'])->name('survey.post');

    Route::get('member/qrcode', [MemberController::class, 'qrcode'])->name('member.qrcode');
    Route::get('member/data/select/json', [MemberController::class, 'json'])->name('member.qrcode');

    // Route::get('/member/qrcode', function () {
    //     return view('dashboard.pages.user.qrcode');
    // })->name('member.qrcode');

//     Route::get('/member/qrcode', function () {

//         $image = QrCode::format('png')
//                          ->merge(public_path('dist/img/icon-kemenkes.png'), 0.5, true)
//                          ->size(250)
//                          ->errorCorrection('H')
//                          ->generate(Auth::user()->member_id);

//         return response($image)->header('Content-type','image/png');
// })->name('member.qrcode');

    Route::get('member/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
    Route::get('member/password/{id}', [MemberController::class, 'editPassword'])->name('member.password');
    Route::get('member/email/{id}', [MemberController::class, 'editEmail'])->name('member.email');
    Route::get('member/detail/{id}', [MemberController::class, 'detail'])->name('member.detail');
    Route::get('member/resend/email/{id}', [MemberController::class, 'resendEmail'])->name('member.resendMail');
    Route::post('member/update/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::post('member/update/password/{id}', [MemberController::class, 'updatePassword'])->name('member.updatePassword');
    Route::post('member/update/email/{id}', [MemberController::class, 'updateEmail'])->name('member.updateEmail');

    Route::get('class', [KelasController::class, 'show'])->name('kelas');
    Route::get('class/detail/{id}', [KelasController::class, 'detail'])->name('kelas.detail');

    // Jadwal Kelas Member
    Route::get('class/schedule', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::get('class/schedule/cari/{id}', [JadwalController::class, 'filter'])->name('jadwal.pilih');
    Route::get('class/schedule/join/{id}', [JadwalController::class, 'join'])->name('jadwal.join');
    Route::post('class/schedule/join/{id}', [JadwalController::class, 'join'])->name('jadwal.join');
    Route::post('class/schedule/cancel/{id}', [JadwalController::class, 'cancel'])->name('jadwal.cancel');

    Route::get('bodyck', [BodyckController::class, 'show'])->name('bodyck');
    Route::get('bodyck/detail/{id}', [BodyckController::class, 'detail'])->name('bodyck.detail');
    Route::get('bodyck/edit/{id}', [BodyckController::class, 'edit'])->name('bodyck.edit');
    Route::get('bodyck/create', [BodyckController::class, 'create'])->name('bodyck.create');
    Route::post('bodyck/store', [BodyckController::class, 'create'])->name('bodyck.store');
    Route::post('bodyck/update/{id}', [BodyckController::class, 'edit'])->name('bodyck.update');

    Route::get('bodycp', [BodycpController::class, 'show'])->name('bodycp');
    Route::get('bodycp/progres/chart', [BodycpController::class, 'chart'])->name('bodycp.chart');

    Route::get('workout', [WorkoutController::class, 'show'])->name('workout');

    Route::get('progress', [ProgresController::class, 'show'])->name('progres');
    Route::get('progress/chart', [ProgresController::class, 'chart'])->name('progres.chart');

    Route::get('faq', [FaqController::class, 'show'])->name('faq');

    Route::get('konsultasi', [KonsulController::class, 'show'])->name('konsul');
    Route::get('konsultasi/reset', [KonsulController::class, 'reset'])->name('konsul.reset');
    Route::get('konsultasi/tambah', [KonsulController::class, 'store'])->name('konsul.store');
    Route::get('konsultasi/batal', [KonsulController::class, 'cancel'])->name('konsul.cancel');
    Route::get('konsultasi/detail/{id}', [KonsulController::class, 'detail'])->name('konsul.detail');
    Route::get('konsultasi/hapus/{id}', [KonsulController::class, 'delete'])->name('konsul.delete');
    Route::get('konsultasi/download/{id}', [KonsulController::class, 'download'])->name('konsul.download');

    Route::get('/antrian-konsul', [KonsulController::class, 'antrianKonsul']);

    Route::group(['middleware' => ['access:admin']], function () {
        Route::get('kelas/kehadiran/{id}', [JadwalController::class, 'attendance'])->name('kelas.attendance');
        Route::get('class/schedule/detail/{id}', [JadwalController::class, 'detail'])->name('jadwal.detail');

        Route::get('konsultasi/member/{id}', [KonsulController::class, 'riwayat'])->name('konsul.user.detail');
        Route::get('konsultasi/update/{id}', [KonsulController::class, 'update'])->name('konsul.update');

        Route::get('member', [MemberController::class, 'show'])->name('member');
        Route::get('member/search', [MemberController::class, 'search'])->name('member.search');
        Route::get('member/search/{var}/{id}', [MemberController::class, 'searchBy'])->name('member.searchBy');
        Route::get('member/delete/{id}', [MemberController::class, 'delete'])->name('member.delete');
        Route::get('member/delete-minat/{id}', [MemberController::class, 'deleteMinat'])->name('member.deleteMinat');

        Route::get('user', [UserController::class, 'show'])->name('user');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('user/store', [UserController::class, 'store'])->name('user.store');
        Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');

        // Kelas
        Route::get('class/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::post('class/update/{id}', [KelasController::class, 'update'])->name('kelas.update');

        // Jadwal
        Route::get('class/create/schedule/{id}', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::get('class/create/tanggal/schedule/{id}', [JadwalController::class, 'createByDate'])->name('jadwal.createByDate');
        Route::get('class/edit/schedule/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::post('class/store/schedule', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::post('class/update/schedule/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::post('peserta/update/kehadiran/{id}', [JadwalController::class, 'updateKehadiran'])->name('kehadiran.update');

        Route::get('class/schedule/delete/{id}', [JadwalController::class, 'cancelJoin'])->name('join.delete');

        Route::get('absen/report', [AbsenController::class, 'report'])->name('absen.report');
        Route::get('absen/chart', [AbsenController::class, 'chart'])->name('absen.chart');
        Route::get('absen/filter', [AbsenController::class, 'filter'])->name('absen.filter');
        Route::get('absen/delete/{id}', [AbsenController::class, 'delete'])->name('absen.delete');
        Route::post('absen/edit/{id}', [AbsenController::class, 'update'])->name('absen.update');

        // Penalty
        Route::get('penalty', [PenaltyController::class, 'show'])->name('penalty');
        Route::get('penalty/delete/{id}', [PenaltyController::class, 'delete'])->name('penalty.delete');
        Route::post('penalty/update/{id}', [PenaltyController::class, 'update'])->name('penalty.update');

        // FAQ
        Route::get('faq/store', [FaqController::class, 'store'])->name('faq.store');
    });
});
