<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'uker_id',
        'member_id',
        'nip_nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'instansi',
        'nama_instansi',
        'tinggi',
        'berat',
        'email',
        'no_telp',
        'username',
        'password',
        'password_teks',
        'keterangan',
        'isVerify',
        'status',
        'foto'
    ];

    public function absen() {
        return $this->hasMany(Absensi::class, 'user_id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function uker() {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }

    public function minatKelas() {
        return $this->hasMany(MinatKelas::class, 'member_id');
    }

    public function minatTarget() {
        return $this->hasMany(MinatTarget::class, 'member_id');
    }

    public function bodyCk() {
        return $this->hasMany(Bodyck::class, 'member_id');
    }

    public function classActive() {
        return $this->hasMany(Peserta::class, 'member_id')->where('kehadiran', null);
    }

    public function absenClass() {
        return $this->hasOne(Peserta::class, 'member_id')->join('t_jadwal','id_jadwal','jadwal_id')->join('t_kelas','id_kelas','kelas_id')->orderBy('id_peserta', 'DESC');
    }

    public function penalty() {
        return $this->hasMany(Penalty::class, 'user_id')->join('t_jadwal','id_jadwal','jadwal_id')->where('status', 'false');
    }

    public function konsul() {
        return $this->hasMany(Konsultasi::class, 'member_id');
    }
}
