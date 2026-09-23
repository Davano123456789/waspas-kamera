<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerhitunganBatch extends Model
{
    use HasFactory;

    protected $table = 'perhitungan_batch';

    protected $fillable = [
        'kode_batch',
        'created_by',
    ];

    public function hasil()
    {
        return $this->hasMany(PerhitunganHasil::class, 'batch_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
