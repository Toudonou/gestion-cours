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
        Schema::create('cours_locals', function (Blueprint $table) {
            $table->id();
            $table->string('intitule');
            $table->integer('masseHoraire');
            $table->integer('semestre');
            $table->string('filiere');
            $table->foreignId('ue_id')->constrained();
            $table->foreignId('enseignant_local_id')->constrained();
            $table->foreignId('directeur_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours_locals');
    }
};
