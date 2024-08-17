<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leaderboard extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_leaderboard";
    protected $primaryKey = "id_leaderboard";
    public $timestamps = false;

    protected $fillable = [
        'id_leaderboard',
        'challenge_id',
        'kategori',
        'member_id',
        'peringkat',
        'nilai'
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function challenge() {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }
}
