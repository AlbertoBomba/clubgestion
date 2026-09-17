<?php

namespace App\Mail;

use App\Classes\PdfFile;
use App\Models\PaymentPlayer;
use App\Models\SportsSchool;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class PaymentPlayerLetter extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PaymentPlayer $payment,
        public SportsSchool $school,
        public ?string $pdfContent = null,
        public ?string $pdfFilename = null,
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = 'notify@vaed.es';
        $fromName = $this->school->mail_from_name
            ?: ($this->school->name ?: config('mail.from.name'));

        $replyAddress = $this->school->email ?: 'notify@vaed.es';

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            replyTo: [
                new Address($replyAddress, $fromName),
            ],
            subject: 'Carta de pago ' . ($this->payment->code ?? '') . ' - ' . ($this->school->name ?? config('app.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-player-letter',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent ?? $this->buildPdf(), $this->resolveFilename())
                ->withMime('application/pdf'),
        ];
    }

    protected function resolveFilename(): string
    {
        if (! empty($this->pdfFilename)) {
            return $this->pdfFilename;
        }

        $slug = Str::slug($this->payment->code ?: (string) $this->payment->id);

        return 'carta_pago_' . $slug . '.pdf';
    }

    /**
     * Genera el PDF de la carta de pago cuando no se ha suministrado
     * (patrón usado por el envío masivo encolado en jobs).
     */
    protected function buildPdf(): string
    {
        $data = [
            'payment'       => $this->payment,
            'player'        => $this->payment->player,
            'sportsSchool'  => $this->school,
            'generatedDate' => now()->format('d/m/Y H:i'),
        ];

        $pdf = new PdfFile();
        $pdf->file_name = 'carta_pago_' . ($this->payment->code ?: $this->payment->id);
        $pdf->templates[0] = 'pdfs.payment-card';
        $pdf->records = ['data' => $data];

        return (string) $pdf->generateFromTemplate($pdf->templates[0]);
    }
}
