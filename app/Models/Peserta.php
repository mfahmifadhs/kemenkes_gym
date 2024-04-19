<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_kelas_peserta";
    protected $primaryKey = "id_peserta";
    public $timestamps = false;

    protected $fillable = [
        'id_peserta',
        'jadwal_id',
        'member_id',
        'tanggal_latihan',
        'kehadiran'
    ];

    public function jadwal() {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function member() {
        return $this->belongsTo(User::class, 'member_id')->orderBy('nama', 'ASC');
    }
}
