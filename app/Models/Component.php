<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_component";
    protected $primaryKey = "id_component";
    public $timestamps = false;

    protected $fillable = [
        'id_component',
        'kategori',
        'judul',
        'deskripsi'
    ];
}
