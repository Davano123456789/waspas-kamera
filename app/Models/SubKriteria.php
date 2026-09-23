<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriteria';

    protected $fillable = [
        'kriteria_id',
        'nama',
        'nilai',
        'nilai_min',
        'nilai_maks',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    /**
     * Find the sub-kriteria whose [nilai_min, nilai_maks] range covers the given value.
     * Bounds are inclusive; a null bound means open-ended on that side.
     * When multiple ranges match, the highest scoring one wins.
     */
    public static function matchForValue(int $kriteriaId, float $value): ?self
    {
        return static::where('kriteria_id', $kriteriaId)
            ->where(function ($q) use ($value) {
                $q->whereNull('nilai_min')->orWhere('nilai_min', '<=', $value);
            })
            ->where(function ($q) use ($value) {
                $q->whereNull('nilai_maks')->orWhere('nilai_maks', '>=', $value);
            })
            ->orderByDesc('nilai')
            ->first();
    }
}
