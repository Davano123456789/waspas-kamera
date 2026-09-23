<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerhitunganHasil extends Model
{
    use HasFactory;

    protected $table = 'perhitungan_hasil';

    protected $fillable = [
        'batch_id',
        'kamera_id',
        'kode_kamera',
        'nama_kamera',
        'merk',
        'q1',
        'q2',
        'qi',
        'rank',
    ];

    public function batch()
    {
        return $this->belongsTo(PerhitunganBatch::class, 'batch_id');
    }

    public function kamera()
    {
        return $this->belongsTo(Kamera::class, 'kamera_id');
    }
}
