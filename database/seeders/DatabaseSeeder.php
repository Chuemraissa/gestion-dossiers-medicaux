<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Charge les rôles, puis crée le premier compte administrateur à l'installation.
     * Ses informations viennent du fichier .env (variables ADMIN_*),
     * pour pouvoir se connecter une première fois et créer les autres comptes.
     *
     * Commande : php artisan db:seed
     */
    public function run(): void
    {
        $this->call([RoleSeeder::class, ListeSeeder::class, ParametreSeeder::class]);

        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (empty($email) || empty($password)) {
            $this->command->warn('ADMIN_EMAIL ou ADMIN_PASSWORD manquant dans .env : aucun administrateur créé.');

            return;
        }

        if (Resource::where('email', $email)->exists()) {
            $this->command->info("L'administrateur {$email} existe déjà.");

            return;
        }

        Resource::create([
            'nom_prenom' => env('ADMIN_NOM', 'Administrateur'),
            'adresse' => env('ADMIN_ADRESSE', '-'),
            'date_naissance' => env('ADMIN_DATE_NAISSANCE', '2000-01-01'),
            'telephone' => env('ADMIN_TELEPHONE', '-'),
            'sexe' => env('ADMIN_SEXE', '-'),
            'email' => $email,
            'password' => $password,
            // Premier rôle qui a la gestion du personnel (l'administrateur)
            'role' => Role::codesAvecAcces('gestion_personnel')[0] ?? null,
        ]);

        $this->command->info("Administrateur {$email} créé.");
    }
}
