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
        Schema::create('cartes_visites', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('entreprise');
            $table->string('titre');
            $table->json('coordonnees');
            $table->json('autres_champs')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carte_visites');
    }
};
