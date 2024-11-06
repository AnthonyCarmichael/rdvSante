<?php

namespace App\Mail;


use App\Models\Rdv;
use App\Models\Taxe;
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
    public $rdv, $professionnel, $urlModif, $urlAnnuler,$tps,$tvq,$total;
    public function __construct(Rdv $rdv,User $professionnel,Taxe $tps, Taxe $tvq)
    {
        $this->rdv = $rdv;
        $this->professionnel = $professionnel;
        $this->tps = $tps;
        $this->tvq = $tvq;
        $this->total = number_format($this->rdv->service->prix + $this->tps->valeur + $this->tvq->valeur, 2);
        $baseUrl = config('app.url');
        $baseUrl .= ':8000';
        // URL de modification
        $this->urlModif = "{$baseUrl}/rendez-vous/modifier/{$this->rdv->id}?token={$this->rdv->token}";

        // URL d'annulation
        $this->urlAnnuler= "{$baseUrl}/rendez-vous/annuler/{$this->rdv->id}?token={$this->rdv->token}";

    }

    public function build()
    {
        return $this->markdown('email.confirmerRdv')
            ->subject('Confirmation du rendez-vous avec '.$this->professionnel->prenom.' ' .$this->professionnel->nom)
            ->with([
                'rdv' => $this->rdv,
                'professionnel' => $this->professionnel,
                'tps' => $this->tps,
                'tvq' => $this->tvq,
                'total' => $this->total
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
