<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BodyckParam extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_bodyck_param";
    protected $primaryKey = "id_param";
    public $timestamps = false;

    protected $fillable = [
        'id_param',
        'nama_param',
        'satuan',
        'deskripsi'
    ];

    public function kelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
