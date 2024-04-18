<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'coach_id'
    ];

    public function jadwal() {
        return $this->hasMany(Jadwal::class, 'kelas_id');
    }
}
