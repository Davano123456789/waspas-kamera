<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamera extends Model
{
    use HasFactory;

    protected $table = 'kamera';

    protected $fillable = [
        'kode',
        'nama',
        'merk',
        'deskripsi',
    ];

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'kamera_id');
    }
}
