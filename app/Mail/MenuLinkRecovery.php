<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MenuLinkRecovery extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $menus) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seus links de edição do cardápio – QRGenerate.net',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.menu-link-recovery',
        );
    }
}
