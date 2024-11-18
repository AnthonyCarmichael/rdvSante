<?php

namespace App\Notifications;

use App\Models\Rdv;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelRendezVous extends Notification
{
    use Queueable;
    private $rdv;

    /**
     * Create a new notification instance.
     */
    public function __construct($rdv)
    {
        $this->rdv = $rdv;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rappel de votre rendez-vous')
            ->greeting('Bonjour ' . $this->rdv->client->prenom .' '. $this->rdv->client->nom.',')
            ->line('Ceci est un rappel pour votre rendez-vous prévu dans 24 heures.')
            ->line('Heure: '.$this->rdv->dateHeureDebut)
            ->line('Addresse: '.$this->rdv->clinique->nom)
            ->line('Merci de nous faire confiance.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
