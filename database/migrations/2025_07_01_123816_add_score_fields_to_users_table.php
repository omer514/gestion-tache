<?php

// database/migrations/xxxx_xx_xx_add_score_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_score')->default(0);
            $table->string('niveau')->default('Débutant');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_score', 'niveau']);
        });
    }
};
