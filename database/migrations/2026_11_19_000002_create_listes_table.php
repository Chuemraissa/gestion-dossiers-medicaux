<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Listes de choix utilisées dans les formulaires (statuts de rendez-vous, types d'examen,
 * groupes sanguins...). Elles sont en base pour pouvoir être modifiées sans toucher au code.
 * Les valeurs de départ sont chargées par "php artisan db:seed" (ListeSeeder).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listes', function (Blueprint $table) {
            $table->id();
            $table->string('liste');           // nom de la liste, ex. "statuts_rdv"
            $table->string('valeur');          // valeur enregistrée, ex. "en_attente"
            $table->string('libelle');         // texte affiché, ex. "En attente"
            $table->unsignedInteger('ordre')->default(0);
            $table->timestamps();

            $table->unique(['liste', 'valeur']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listes');
    }
};
