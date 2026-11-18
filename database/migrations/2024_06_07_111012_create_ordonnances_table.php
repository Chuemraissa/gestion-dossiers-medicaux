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
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
    
            $table->foreignId('medicament_id')->constrained();
            $table->foreignId('posologie_id')->constrained();
            $table->foreignId('examen_id')->constrained();
    
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
        Schema::dropIfExists('ordonnances');
    }
};