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
       Schema::create('rappels', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tache_id')->constrained()->onDelete('cascade');
    $table->string('message');
    $table->dateTime('heure_rappel');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rappels');
    }
};
