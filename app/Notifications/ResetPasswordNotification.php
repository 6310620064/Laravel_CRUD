<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url = $this->signedUrl($notifiable->email, $this->token);

        return (new MailMessage)
            ->line('คุณได้รับอีเมลนี้เนื่องจากเราได้รับคำขอรีเซ็ตรหัสผ่านสำหรับบัญชีของคุณ')
            ->action('รีเซ็ตรหัสผ่าน', $url)
            ->line('หากคุณไม่ได้ร้องขอการรีเซ็ตรหัสผ่าน ไม่จำเป็นต้องดำเนินการใดๆ');
    }

     /**
     * Generate the signed URL for the password reset link.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function signedUrl($notifiable)
    {
        return URL::signedRoute('password.reset', ['token' => $this->token]);
    }
}
