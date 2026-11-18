<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Une ordonnance peut être créée avant de choisir le médicament
 * (par exemple en attendant les résultats d'un examen).
 * Les champs de posologie peuvent aussi rester vides.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordonnances', function (Blueprint $table) {
            $table->unsignedBigInteger('medicament_id')->nullable()->change();
        });

        Schema::table('posologies', function (Blueprint $table) {
            $table->string('dose')->nullable()->default(null)->change();
            $table->string('frequence')->nullable()->default(null)->change();
            $table->string('duree')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('ordonnances', function (Blueprint $table) {
            $table->unsignedBigInteger('medicament_id')->nullable(false)->change();
        });

        Schema::table('posologies', function (Blueprint $table) {
            $table->string('dose')->default(0)->nullable(false)->change();
            $table->string('frequence')->default(0)->nullable(false)->change();
            $table->string('duree')->default(0)->nullable(false)->change();
        });
    }
};
