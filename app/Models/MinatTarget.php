<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MinatTarget extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_minat_target";
    protected $primaryKey = "id_minat_target";
    public $timestamps = false;

    protected $fillable = [
        'id_minat_target',
        'member_id',
        'target_id'
    ];

    public function target() {
        return $this->belongsTo(Target::class, 'target_id');
    }
}
