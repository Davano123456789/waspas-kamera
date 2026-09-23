<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'kode',
        'nama',
        'atribut',
        'tipe_input',
        'bobot',
        'bobot_normalisasi',
    ];

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'kriteria_id');
    }
}
