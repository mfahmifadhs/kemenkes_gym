<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_absensi";
    protected $primaryKey = "id_absensi";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar'
    ];

    public function member() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
