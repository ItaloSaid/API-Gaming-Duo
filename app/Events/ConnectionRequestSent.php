<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ConnectionRequestSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        // Canal privado para o destinatário
        return new Channel('notifications.' . $this->notification->receiver_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Nova solicitação de conexão!',
            'notification' => $this->notification,
        ];
    }
}
