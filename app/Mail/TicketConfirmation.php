<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// "Mailable" = cetakan email.
// Isi emailnya ada di resources/views/emails/ticket.blade.php
class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    // $registration otomatis bisa dipakai di dalam template email
    public function __construct(public Registration $registration) {}

    // Subjek email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-tiket '.config('konser.name').': '.$this->registration->ticket_code,
        );
    }

    // Template isi email
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
        );
    }
}
