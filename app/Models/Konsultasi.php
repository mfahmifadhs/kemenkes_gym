<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Konsultasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_konsultasi";
    protected $primaryKey = "id_konsultasi";
    public $timestamps = false;

    protected $fillable = [
        'id_konsultasi',
        'member_id',
        'dokter_id',
        'kode_book',
        'test_sipgar',
        'test_fitness',
        'konsultasi',
        'tanggal_konsul',
        'waktu_konsul',
        'catatan_dokter',
        'catatan_pasien'
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function dokter() {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}