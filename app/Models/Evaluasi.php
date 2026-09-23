<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;

    protected $table = 'evaluasi';

    protected $fillable = [
        'kamera_id',
        'kriteria_id',
        'sub_kriteria_id',
        'nilai',
        'nilai_asli',
    ];

    public function kamera()
    {
        return $this->belongsTo(Kamera::class, 'kamera_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id');
    }
}
