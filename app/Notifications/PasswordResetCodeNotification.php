<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetCodeNotification extends Notification
{
    public function __construct(private string $resetCode)
    {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Password')
            ->line('Your password reset code is:')
            ->line($this->resetCode)
            ->line('This code will expire in 1 hour.')
            ->line('If you did not request a password reset, no further action is required.');
    }
}
