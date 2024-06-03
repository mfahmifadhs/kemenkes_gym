<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_jadwal";
    protected $primaryKey = "id_jadwal";
    public $timestamps = false;

    protected $fillable = [
        'id_jadwal',
        'kelas_id',
        'tanggal_kelas',
        'waktu_mulai',
        'waktu_selesai',
        'kuota',
        'nama_pelatih',
        'lokasi'
    ];

    public function kelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function peserta() {
        return $this->hasMany(Peserta::class, 'jadwal_id');
    }
}
