<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'bundle_id',
        'name',
        'url',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function logs()
    {
        return $this->hasMany(LogLink::class);
    }
}

