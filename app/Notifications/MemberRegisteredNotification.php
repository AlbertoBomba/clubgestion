<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Member;

class MemberRegisteredNotification extends Notification
{
    use Queueable;

    public function __construct(public Member $member) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmación de Alta y Mandato SEPA - ' . $this->member->name)
            ->view('emails.member-registered', [
                'member' => $this->member,
            ]);
    }
}
