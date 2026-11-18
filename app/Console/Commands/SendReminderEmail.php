<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail extends Command
{
    protected $signature = 'email:send-reminder';

    protected $description = 'Envoie un email de rappel 30 minutes après la création du rendez-vous.';

    public function handle()
    {
        $email = 'tchuenteraissa30@gmail.com';
        Mail::to($email)->send(new ReminderEmail());
        $this->info('Email de rappel envoyé à ' . $email);
    }
}