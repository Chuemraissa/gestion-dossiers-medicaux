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
        Schema::create('faires', function (Blueprint $table) {
            $table->id();
            $table->string('resultat');
            
            $table->foreignId('examen_id')->constrained()->onDelete('cascade');
            // Relation avec la table 'resources' pour le laborantin
            $table->foreignId('laborantin_id')
                  ->constrained('resources')
                  ->whereHas('resources', function ($query) {
                      $query->where('role', 'laborantin');
                  })
                  ->onDelete('cascade');
            $table->foreignId('patient_id')
                  ->constrained('resources')
                  ->whereHas('resources', function ($query) {
                      $query->where('role', 'patient');
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
        Schema::dropIfExists('faires');
    }
};
