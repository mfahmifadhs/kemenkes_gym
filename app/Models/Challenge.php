<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Challenge extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_challenge";
    protected $primaryKey = "id_challenge";
    public $timestamps = false;

    protected $fillable = [
        'id_challenge',
        'nama_challenge',
        'tanggal',
        'deskripsi',
        'ketentuan',
        'hadiah',
        'foto_challenge'
    ];
}
