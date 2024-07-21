<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bodycp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_bodycp";
    protected $primaryKey = "id_bodycp";
    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'tanggal_cek',
        'height',
        'clothes',
        'weight',
        'fatp',
        'fatm',
        'ffm',
        'pmm',
        'tbw',
        'bonem',
        'bmr',
        'metaage',
        'vfatl',
        'bmi',
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }
}
