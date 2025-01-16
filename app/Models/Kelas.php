<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Kelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_kelas";
    protected $primaryKey = "id_kelas";
    public $timestamps = false;

    protected $fillable = [
        'id_kelas',
        'nama_kelas',
        'deskripsi',
        'coach_id',
        'status'
    ];

    public function jadwal()
    {
        $utama = Auth::user()->uker?->unit_utama_id;

        if ($utama == '46591') {
            return $this->hasMany(Jadwal::class, 'kelas_id')
                ->where('lokasi_id', 2);
        }

        return $this->hasMany(Jadwal::class, 'kelas_id');
    }

    public function minat()
    {
        $utama = Auth::user()->uker->unit_utama_id;

        if ($utama == '46591') {
            return $this->hasMany(MinatKelas::class, 'kelas_id')
                ->whereHas('member', function ($query) {
                    $query->whereHas('uker', function ($subQuery) {
                        $subQuery->where('unit_utama_id', '46591');
                    });
                });
        }

        return $this->hasMany(MinatKelas::class, 'kelas_id');
    }
}
