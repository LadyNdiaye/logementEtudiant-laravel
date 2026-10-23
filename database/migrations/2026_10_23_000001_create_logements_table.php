<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('type'); // chambre, studio ou appartement
            $table->integer('prix_mensuel');
            $table->string('ville');
            $table->string('quartier')->nullable();
            $table->boolean('meuble')->default(false);
            $table->string('photo')->nullable();
            $table->string('statut')->default('disponible'); // disponible ou loue
            $table->foreignId('proprietaire_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logements');
    }
};
