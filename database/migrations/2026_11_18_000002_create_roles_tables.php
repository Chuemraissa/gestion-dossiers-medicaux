<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Les rôles et leurs accès sont stockés en base (et non plus écrits dans le code).
 * Les valeurs de départ sont chargées par "php artisan db:seed" (RoleSeeder).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();      // valeur enregistrée dans resources.role
            $table->string('libelle');             // nom affiché
            $table->boolean('est_patient')->default(false); // rôle donné aux patients
            $table->timestamps();
        });

        Schema::create('role_acces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->string('acces');               // ex. "patients", "prescription"
            $table->timestamps();

            $table->unique(['role_id', 'acces']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_acces');
        Schema::dropIfExists('roles');
    }
};
