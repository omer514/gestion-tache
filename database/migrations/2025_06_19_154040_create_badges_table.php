<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('description')->nullable();
            $table->string('icone')->nullable(); // par exemple, un nom de classe FontAwesome ou URL image
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('badges');
    }
};
