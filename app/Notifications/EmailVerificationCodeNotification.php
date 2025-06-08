<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationCodeNotification extends Notification
{
    public function __construct(private string $verificationCode)
    {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verify Email Address')
            ->line('Your email verification code is:')
            ->line($this->verificationCode)
            ->line('This code will expire in 3 hours.')
            ->line('If you did not create an account, no further action is required.');
    }
}
