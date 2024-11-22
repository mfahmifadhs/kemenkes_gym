<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_lokasi";
    protected $primaryKey = "id_lokasi";
    public $timestamps = false;

    protected $fillable = [
        'id_lokasi',
        'nama_lokasi',
        'keterangan',
        'status'
    ];
}
