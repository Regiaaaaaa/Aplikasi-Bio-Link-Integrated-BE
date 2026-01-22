<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBundle extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'bundle_id',
        'ip_address',
        'user_agent',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}

