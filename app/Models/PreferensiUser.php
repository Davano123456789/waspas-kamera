<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiUser extends Model
{
    use HasFactory;

    protected $table = 'preferensi_user';

    protected $fillable = [
        'user_id',
        'bobot_kustom',
    ];

    protected $casts = [
        'bobot_kustom' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
