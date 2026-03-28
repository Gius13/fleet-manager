<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Crea una nuova istanza della mail.
     * La variabile $vehicles sarà accessibile direttamente nel file Blade.
     */
    public function __construct(public $vehicles) {}

    /**
     * Definisce l'oggetto e i dettagli dell'intestazione.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ SCADENZE FLOTTA: Azione Richiesta',
        );
    }

    /**
     * Collega il file grafico (View) alla mail.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.deadline-notification',
        );
    }

    /**
     * Eventuali allegati (opzionale)
     */
    public function attachments(): array
    {
        return [];
    }
}