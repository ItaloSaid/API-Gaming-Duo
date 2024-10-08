<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'status'];

    public function sender()
    {
        return $this->belongsTo(Usuario::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Usuario::class, 'receiver_id');
    }
}
