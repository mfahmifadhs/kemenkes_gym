<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}
