<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'handle',
        'url',
    ];

    // Relasi ke User (many to one)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
