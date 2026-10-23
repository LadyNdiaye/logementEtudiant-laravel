<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_visite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('logement_id')->constrained('logements')->onDelete('cascade');
            $table->date('date_souhaitee');
            $table->text('message')->nullable();
            $table->string('statut')->default('en_attente'); // en_attente, acceptee ou refusee
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_visite');
    }
};
