<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends BaseResetPassword
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = $this->resetUrl($notifiable);
        $fromAddress = (string) config('mail.from.address');
        $fromName = (string) config('mail.from.name');

        return (new MailMessage)
            ->from($fromAddress, $fromName)
            ->subject('Reset Password Akun - ' . $fromName)
            ->greeting('Halo!')
            ->line('Kami menerima permintaan untuk mengatur ulang password akun Anda.')
            ->action('Atur Ulang Password', $resetUrl)
            ->line('Link reset password ini berlaku selama 60 menit.')
            ->line('Jika Anda tidak merasa meminta reset password, abaikan email ini dan tidak ada perubahan pada akun Anda.')
            ->salutation('Salam, ' . $fromName);
    }
}
