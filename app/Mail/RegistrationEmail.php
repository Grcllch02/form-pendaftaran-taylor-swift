<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $ticketName,
        public int $ticketQuantity,
        public int $totalPrice,
        public string $bookingCode,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran konser berhasil - The Eras Night',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail-template.registration-successful',
            with: [
                'userName' => $this->userName,
                'ticketName' => $this->ticketName,
                'ticketQuantity' => $this->ticketQuantity,
                'totalPrice' => $this->totalPrice,
                'bookingCode' => $this->bookingCode,
                'eventDate' => 'Minggu, 13 Desember 2026',
                'eventTime' => '18.30 WIB',
                'doorTime' => '16.00 WIB',
                'venue' => 'Jakarta, Indonesia (lokasi simulasi)',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
