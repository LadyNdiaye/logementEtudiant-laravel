<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('logement_id')->constrained('logements')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['etudiant_id', 'logement_id']); // pas de doublon
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
