<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Rappel envoyé au patient quelques heures avant son rendez-vous.
 * Elle passe par la file d'attente (php artisan queue:work).
 */
class AppointmentCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $patient,
        public string $medecin,
        public string $date,
        public string $heure,
        public string $statut,
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rappel du rendez-vous')
            ->greeting('Bonjour '.$this->patient.',')
            ->line('Votre rendez-vous avec '.$this->medecin.' ('.$this->statut.') est prévu le '.$this->date.' à '.$this->heure.'.')
            ->line('Merci de ne pas l\'oublier !');
    }
}
