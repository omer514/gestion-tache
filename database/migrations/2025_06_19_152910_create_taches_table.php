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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère vers users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // => user_id INT unsigned NOT NULL, clé étrangère vers users.id, suppression en cascade
            
            $table->string('titre');
            $table->text('description')->nullable();
            $table->enum('priorite', ['faible', 'moyenne', 'haute'])->default('faible');
            $table->enum('statut', ['en_attente', 'en_cours', 'terminee'])->default('en_attente');
            $table->dateTime('echeance')->nullable();
            $table->boolean('est_urgente')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
