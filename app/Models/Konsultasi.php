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
        'hasil_sipgar',
        'kategori_sipgar',
        'test_fitness',
        'hasil_backs',
        'kategori_backs',
        'hasil_dynamo_r',
        'kategori_dynamo_r',
        'hasil_dynamo_l',
        'kategori_dynamo_l',
        'hasil_plank',
        'hasil_situp',
        'kategori_situp',
        'hasil_lingperut',
        'hasil_tekdarah',
        'hasil_nadi',
        'konsultasi',
        'tanggal_konsul',
        'waktu_konsul',
        'antrian_konsul',
        'catatan_dokter',
        'catatan_pasien',
        'status'
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function dokter() {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
