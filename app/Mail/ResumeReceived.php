<?php

namespace App\Mail;

use App\Models\Resume;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResumeReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Resume $resume)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Resume Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
