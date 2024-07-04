<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_survey_kepuasan";
    protected $primaryKey = "id_survey";
    public $timestamps = false;

    protected $fillable = [
        'id_survey',
        'user_id',
        'kepuasan',
        'keterangan'
    ];
}
