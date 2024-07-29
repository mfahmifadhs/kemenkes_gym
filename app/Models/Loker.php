<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loker extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_peminjaman_loker";
    protected $primaryKey = "id_peminjaman";
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'member_id',
        'no_loker',
        'waktu_kembali',
        'kartu_identitas'
    ];


    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }
}
