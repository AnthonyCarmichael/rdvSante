<?php

namespace App\Mail;


use App\Models\Rdv;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmerRdv extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $rdv, $professionnel;
    public function __construct(Rdv $rdv,User $professionnel)
    {
        $this->rdv = $rdv;
        $this->professionnel = $professionnel;
    }

    public function build()
    {
        return $this->markdown('email.confirmerRdv')
            ->subject('Confirmation du rendez-vous avec '.$this->professionnel->prenom.' ' .$this->professionnel->nom)
            ->with([
                'rdv' => $this->rdv,
                'professionnel' => $this->professionnel
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmer Rdv',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.confirmerRdv',
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
