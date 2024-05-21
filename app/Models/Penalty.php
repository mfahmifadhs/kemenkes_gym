<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penalty extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_penalty";
    protected $primaryKey = "id_penalty";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tgl_awal_penalty',
        'tgl_akhir_penalty',
        'status'
    ];

    public function member() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
