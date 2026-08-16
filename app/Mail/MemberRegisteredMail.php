<?php

namespace App\Mail;

use App\Models\Member;
use App\Models\SportsSchool;
use App\Models\MemberType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class MemberRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Member $member,
        public SportsSchool $school,
        public MemberType $memberType,
    ) {} 

    public function envelope(): Envelope
    {

       
       $fromAddress = $this->school->mail_from_address
            ?: ($this->school->mail_username ?: config('mail.from.address'));
        $fromName = $this->school->mail_from_name
            ?: ($this->school->name ?: config('mail.from.name'));
        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Alta '.$this->member->name.' en ' . ($this->school->name ?? config('app.name')),
        );
    }

    public function content(): Content
    {
       return new Content(
            view: 'emails.member-registered',
        );
    }

}
