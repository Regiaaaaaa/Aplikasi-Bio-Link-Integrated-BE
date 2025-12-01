<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'background_color',
        'text_color',
        'button_style',
    ];

    // Relasi ke User (1 theme dimiliki banyak user)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
