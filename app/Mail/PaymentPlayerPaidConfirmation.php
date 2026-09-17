<?php

namespace App\Mail;

use App\Models\PaymentPlayer;
use App\Models\SportsSchool;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentPlayerPaidConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PaymentPlayer $payment,
        public SportsSchool $school,
        public string $pdfContent,
        public string $pdfFilename,
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = $this->school->mail_from_address
            ?: ($this->school->mail_username ?: config('mail.from.address'));
        $fromName = $this->school->mail_from_name
            ?: ($this->school->name ?: config('mail.from.name'));

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Pago confirmado ' . ($this->payment->code ?? '') . ' - ' . ($this->school->name ?? config('app.name')),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.payment-paid-confirmation');
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, $this->pdfFilename)
                ->withMime('application/pdf'),
        ];
    }
}
