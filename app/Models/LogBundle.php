<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBundle extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true; // penting supaya created_at & updated_at auto

    protected $fillable = [
        'id',
        'bundle_id',
        'ip_address',
        'user_agent',
        'created_at',
        'updated_at',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
