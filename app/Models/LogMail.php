<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogMail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_log_email";
    protected $primaryKey = "id_log_email";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'token',
        'isExpired'
    ];
}
