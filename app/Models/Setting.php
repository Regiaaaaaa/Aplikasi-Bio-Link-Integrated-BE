<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'custom_css',
        'custom_js',
        'is_public',
        'page_password',
    ];

    // Relasi ke User (1 user punya 1 setting)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
