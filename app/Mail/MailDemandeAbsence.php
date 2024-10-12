<?php

namespace App\Mail;

use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailDemandeAbsence extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Summary of absence
     *
     * @var Absence
     */
    public $absence;

    /**
     * Summary of user
     *
     * @var User
     */
    public $user;

    /**
     * Summary of motif
     *
     * @var Motif
     */
    public $motif;

    /**
     * Create a new message instance.
     */
    public function __construct(Absence $absence, User $user, Motif $motif)
    {
        $this->absence = $absence;
        $this->user = $user;
        $this->motif = $motif;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Absence request'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.demande_absence',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
