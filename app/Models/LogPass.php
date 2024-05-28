<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogPass extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_log_password";
    protected $primaryKey = "id_log_password";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'token',
        'isExpired'
    ];
}
