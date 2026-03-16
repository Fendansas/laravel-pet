<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ExportReadyMail extends Mailable
{
    public $zipName;
    public $password;

    public function __construct($zipName, $password)
    {
        $this->zipName = $zipName;
        $this->password = $password;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ваш Excel файл готов',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.export-ready',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
