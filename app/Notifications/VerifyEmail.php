<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $locale;

    public function __construct(string $locale = 'en')
    {
        $this->locale = $locale;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->view('emails.verify-email', [
                'url'      => $verificationUrl,
                'username' => $notifiable->username,
            ]);
    }

    protected function verificationUrl(object $notifiable): string
    {
        $backendUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addHours(2),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        $parsedUrl = parse_url($backendUrl);
        parse_str($parsedUrl['query'], $queryParams);

        $verificationUrl = config('app.frontend_url') . '/verify-email?' . http_build_query([
            'id'        => $notifiable->getKey(),
            'hash'      => sha1($notifiable->getEmailForVerification()),
            'expires'   => $queryParams['expires'],
            'signature' => $queryParams['signature'],
            'locale'    => $this->locale,
        ]);

        return $verificationUrl;
    }
}
