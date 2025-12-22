<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'theme_id',
        'name',
        'slug',
        'description',
        'profile_image',
        'instagram_url',
        'github_url',
        'tiktok_url',
        'facebook_url',
        'x_url',
        'youtube_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function logs()
    {
        return $this->hasMany(LogBundle::class);
    }
}

