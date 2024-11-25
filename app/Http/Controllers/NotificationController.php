<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Events\ConnectionRequestSent;


class NotificationController extends Controller
{
    public function sendConnectionRequest(Request $request)
    {
        // Verificar se o usuário está autenticado
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        // Validação simples sem verificação em outra tabela
        $validatedData = $request->validate([
            'receiver_id' => 'required',
        ]);

        // Verificar se a solicitação já foi enviada
        $existingNotification = Notification::where('sender_id', $userId)
            ->where('receiver_id', $validatedData['receiver_id'])
            ->where('status', 'pending')
            ->first();

        if ($existingNotification) {
            return response()->json(['message' => 'Solicitação já enviada'], 400);
        }

        // Criar a notificação
        $notification = Notification::create([
            'sender_id' => $userId,
            'receiver_id' => $validatedData['receiver_id'],
            'status' => 'pending',
        ]);
        event(new ConnectionRequestSent($notification));

        // Retornar sucesso
        return response()->json(['notification' => $notification], 201);
    }

    // Aceitar ou rejeitar a solicitação de conexão
    public function respondToRequest(Request $request, $notificationId)
    {
        // Validar o status enviado (aceito ou rejeitado)
        $validatedData = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // Encontrar a notificação pelo ID
        $notification = Notification::find($notificationId);

        // Verificar se a notificação existe e se o usuário é o destinatário
        if (!$notification || $notification->receiver_id != Auth::id()) {
            return response()->json(['message' => 'Notificação não encontrada ou você não tem permissão para respondê-la'], 404);
        }

        // Atualizar o status da notificação
        $notification->update([
            'status' => $validatedData['status'],
        ]);

        return response()->json(['message' => 'Notificação atualizada com sucesso', 'notification' => $notification], 200);
    }

    public function getPendingNotifications()
    {
        // Obter o ID do usuário autenticado
        $userId = Auth::id();

        // Verificar se o usuário está autenticado
        if (!$userId) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        // Buscar todas as notificações pendentes para esse usuário e carregar o remetente (sender) da tabela usuarios
        $notifications = Notification::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->with('sender') // Carregar as informações do remetente da tabela usuarios
            ->get();

        // Retornar as notificações com o nome do remetente (username)
        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                // Verificar se o remetente existe antes de acessar o username
                return [
                    'id' => $notification->id,
                    'sender_nick' => $notification->sender ? $notification->sender->username : 'Usuário desconhecido', // Evita erro se sender for null
                    'receiver_id' => $notification->receiver_id,
                    'status' => $notification->status,
                    'created_at' => $notification->created_at,
                    'updated_at' => $notification->updated_at,
                ];
            })
        ], 200);
    }
}
