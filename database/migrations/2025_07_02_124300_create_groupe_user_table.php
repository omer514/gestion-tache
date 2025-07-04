<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('groupe_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('accepte')->default(false); // devient true quand l'utilisateur accepte l'invitation
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('groupe_user');
    }
};