<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Informations de l'établissement (nom, adresse, téléphones) affichées
 * sur les documents imprimés et la page d'aide. Modifiables sans toucher au code.
 * Valeurs de départ chargées par "php artisan db:seed" (ParametreSeeder).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->unique();
            $table->string('valeur')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametres');
    }
};
