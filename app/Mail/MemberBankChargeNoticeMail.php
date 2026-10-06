<?php

namespace App\Mail;

use App\Models\MemberSeason;
use App\Models\MemberType;
use App\Models\SportsSchool;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class MemberBankChargeNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public MemberSeason $memberSeason,
        public SportsSchool $school,
        public MemberType $memberType,
        public Carbon $chargeDate,
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = $this->school->mail_from_address
            ?: ($this->school->mail_username ?: config('mail.from.address'));
        $fromName = $this->school->mail_from_name
            ?: ($this->school->name ?: config('mail.from.name'));

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Aviso de cargo en cuenta - ' . ($this->school->name ?? config('app.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.member-bank-charge-notice',
        );
    }
}
