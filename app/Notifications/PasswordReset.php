<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    public $locale;

    public function __construct(string $token, string $locale = 'en')
    {
        $this->token = $token;
        $this->locale = $locale;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Reset Your Password')
            ->view('emails.password-reset', [
                'url'      => $resetUrl,
                'username' => $notifiable->username,
            ]);
    }

    protected function resetUrl(object $notifiable): string
    {
        $resetUrl = config('app.frontend_url') . '/reset-password?' . http_build_query([
            'token'  => $this->token,
            'email'  => $notifiable->email,
            'locale' => $this->locale,
        ]);

        return $resetUrl;
    }
}
