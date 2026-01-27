<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogLink extends Model
{
    use HasFactory;

    public $incrementing = false; // karena pakai UUID

    protected $keyType = 'string';

    public $timestamps = true; // supaya created_at & updated_at otomatis

    protected $fillable = [
        'id',
        'link_id',
        'ip_address',
        'user_agent',
        'created_at',
        'updated_at',
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
