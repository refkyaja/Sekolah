<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class SiswaOtpNotification extends Notification
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Kode Reset Password'))
            ->greeting('Halo!')
            ->line(Lang::get('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.'))
            ->line(Lang::get('Kode verifikasi Anda adalah:'))
            ->line('**' . $this->otp . '**')
            ->line(Lang::get('Kode ini akan kedaluwarsa dalam 5 menit.'))
            ->line(Lang::get('Jika Anda tidak meminta reset password, abaikan email ini.'))
            ->salutation('Salam, TK PGRI Harapan Bangsa 1');
    }
}
