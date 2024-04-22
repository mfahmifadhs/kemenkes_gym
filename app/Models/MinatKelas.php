<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MinatKelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_minat_kelas";
    protected $primaryKey = "id_minat_kelas";
    public $timestamps = false;

    protected $fillable = [
        'id_minat_kelas',
        'member_id',
        'kelas_id'
    ];

    public function kelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function target() {
        return $this->belongsTo(Target::class, 'target_id');
    }
}
