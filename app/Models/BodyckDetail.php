<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BodyckDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_bodyck_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'id_detail',
        'bodyck_id',
        'param_id',
        'nilai'
    ];

    public function bodyck() {
        return $this->belongsTo(Bodyck::class, 'bodyck_id');
    }

    public function param() {
        return $this->belongsTo(BodyckParam::class, 'param_id');
    }
}
