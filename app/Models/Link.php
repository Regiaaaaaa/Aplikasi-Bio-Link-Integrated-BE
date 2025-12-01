<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'url',
        'icon',
        'bg_color',
        'text_color',
        'order',
        'is_active',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke ClickLog
    public function clickLogs()
    {
        return $this->hasMany(ClickLog::class, 'link_id');
    }
}
