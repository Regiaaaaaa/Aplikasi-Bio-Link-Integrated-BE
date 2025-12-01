<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClickLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    // Relasi ke Link
    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    // Relasi ke User (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
