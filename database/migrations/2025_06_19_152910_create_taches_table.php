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
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('titre');
    $table->text('description')->nullable();
    $table->enum('priorite', ['faible', 'moyenne', 'haute'])->default('moyenne');
    $table->enum('statut', ['en_attente', 'en_cours', 'terminee'])->default('en_attente');
    $table->boolean('est_urgente')->default(false);
    $table->dateTime('echeance')->nullable();
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
