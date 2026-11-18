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
        Schema::create('consulters', function (Blueprint $table) {
            $table->id();
            $table->string('motif');
            $table->string('type');
            $table->string('symptome');
            $table->string('diagnostic');
            $table->string('cout');
            
            // Relation avec la table 'resources' pour le patient
            $table->foreignId('patient_id')
                  ->constrained('resources')
                  ->whereHas('resources', function ($query) {
                      $query->where('role', 'patient');
                  })
                  ->onDelete('cascade');
                  
            $table->foreignId('medecin_id')
                  ->constrained('resources')
                  ->whereHas('resources', function ($query) {
                      $query->where('role', 'medecin');
                  })
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulters');
    }
};
