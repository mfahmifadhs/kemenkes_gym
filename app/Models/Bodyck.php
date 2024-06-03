<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bodyck extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_bodyck";
    protected $primaryKey = "id_bodyck";
    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'tanggal_cek',
        'no_serial',
        'tipe_badan',
        'bodyck_tinggi',
        'berat_baju',
        'bodyck_keterangan',
        'bodyck_status',
        'bodyck_file'
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function detail() {
        return $this->hasMany(BodyckDetail::class, 'bodyck_id');
    }
}
