<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogLink extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'link_id',
        'ip_address',
        'user_agent',
        'created_at',
        'updated_at',
    ];

    // AUTO-GENERATE UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
