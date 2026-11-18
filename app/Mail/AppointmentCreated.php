<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reminder')
                    ->subject('Rappel de rendez-vous')
                    ->with([
                        'appointmentDate' => $this->appointment->date,
                        'appointmentTime' => $this->appointment->heure,
                        'patientName' => $this->appointment->patient->nom_prenom,
                        'medecinName' => $this->appointment->medecin->nom_prenom,
                    ]);
    }
}
