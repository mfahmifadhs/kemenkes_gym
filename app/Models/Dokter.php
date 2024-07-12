<?php

namespace App\Models;

use App\Exports\MemberExport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_dokter";
    protected $primaryKey = "id_dokter";
    public $timestamps = false;

    protected $fillable = [
        'id_dokter',
        'nama_dokter',
        'spesialisasi',
        'profil_dokter',
        'lokasi_praktik',
        'jadwal_praktik',
        'foto_dokter'
    ];

    public function pasien() {
        return $this->hasMany(Konsultasi::class, 'dokter_id');
    }
}
