<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AppointmentCreated extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $patient;
    protected $medecin;
    protected $date;
    protected $heure;
    protected $statut;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($patient,$medecin,$date,$heure,$statut)
    {
        $this->patient = $patient;
        $this->medecin = $medecin;
        $this->date = $date;
        $this->heure = $heure;
        $this->statut = $statut;
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
            ->greeting('Bonjour '. $this->patient . '.')
            ->line('Votre rendez-vous avec le patient'. $this->medecin . '  est'. $this->statut . ' pour le'. $this->date . '  à '. $this->heure . '.')
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