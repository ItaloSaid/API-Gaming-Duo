<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\CustomResetPassword;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable, CanResetPassword;

    protected $table = 'usuarios';

    protected $fillable = [
        'username', 'email', 'senha', 'avatar', 'rank', 'gamename'
    ];

    protected $hidden = [
        'senha', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}
