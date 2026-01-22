<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogLink extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'link_id',
        'ip_address',
        'user_agent',
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}

