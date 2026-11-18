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
        Schema::create('params', function (Blueprint $table) {
            $table->id();
            $table->string('poids');
            $table->string('taille');
            $table->string('temperature');
            $table->string('pression_arterielle');
            $table->string('groupe_sanguin');
            $table->timestamps();

            $table->foreignId('resource_id')->constrained('resources')->whereHas('resources',
            function($query){
                $query->where('role', 'patient');
            }
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('params');
    }
};
