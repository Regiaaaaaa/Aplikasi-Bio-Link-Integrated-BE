<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'theme_id',
        'name',
        'username',
        'email',
        'bio',
        'avatar',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // RELASI 1 USER = 1 SETTINGS
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function socialProfiles()
    {
        return $this->hasMany(SocialProfile::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function clickLogs()
    {
        return $this->hasMany(ClickLog::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
