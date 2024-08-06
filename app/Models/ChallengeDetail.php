<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChallengeDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_challenge_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'id_detail',
        'challenge_id',
        'member_id'
    ];

    public function challenge() {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function bodyCp() {
        return $this->hasMany(User::class, 'member_id');
    }
}
