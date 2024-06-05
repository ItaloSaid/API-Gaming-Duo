<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorantStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jogador',
        'rank',
        'agente_preferido',
        'funcao_preferida',
    ];
}
