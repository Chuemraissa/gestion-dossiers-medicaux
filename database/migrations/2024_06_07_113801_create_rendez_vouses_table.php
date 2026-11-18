<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('heure');
            $table->string('statut');
            $table->string('motif');
            $table->timestamps();

            
            // Relation avec la table 'resources' pour le patient
            $table->foreignId('patient_id')
                  ->constrained('resources')
                  ->whereHas('resources', function ($query) {
                      $query->where('role', 'patient');
                  });
    
            // Relation avec la table 'resources' pour le médecin
            $table->foreignId('medecin_id')
                  ->constrained('resources')
                  ->whereHas('resources', function ($query) {
                      $query->where('role', 'medecin');
                  });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
