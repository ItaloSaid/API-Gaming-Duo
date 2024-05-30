<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios'; // Especifica a tabela 'usuarios'

    protected $fillable = [
        'username', 'email', 'senha', 'avatar'
    ];

    protected $hidden = [
        'senha', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }
}
