<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AppointmentCreatedMedecin extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Pas besoin de délai ici, il sera appliqué lors de l'envoi
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Rappel du rendez-vous')
            ->greeting('Bonjour '. $this->medecin . '.')
            ->line('Votre rendez-vous avec le patient'. $this->patient . '  est'. $this->statut . ' pour le'. $this->date . '  à '. $this->heure . '.')
            ->line('Merci de ne pas l\'oublier!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable"
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}