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
            $table->unsignedBigInteger('user_id');
            $table->string('nom');
            $table->string('tel');
            $table->string('entreprise');
            $table->string('titre');
            $table->string('coordonnees');
            $table->string('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('Users')->onDelete('cascade')->onUpdate('cascade');
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
