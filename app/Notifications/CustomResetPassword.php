<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->view('vendor.notifications.email', ['actionUrl' => $url])
            ->subject('Redefinição de Senha - Gaming Duo')
            ->greeting('Olá!')
            ->line('Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta na Gaming Duo.')
            ->action('Redefinir Senha', $url)
            ->line('Este link de redefinição de senha irá expirar em 60 minutos.')
            ->line('Se você não solicitou uma redefinição de senha, por favor, ignore este e-mail ou entre em contato com nosso suporte.')
            ->salutation('Atenciosamente, Equipe Gaming Duo');
    }

    public function build()
    {
        return $this
            ->subject('Redefinição de Senha - Gaming Duo')
            ->view('notifications.custom_reset_password')
            ->with([
                'actionUrl' => $this->resetUrl,
            ]);
    }
}
