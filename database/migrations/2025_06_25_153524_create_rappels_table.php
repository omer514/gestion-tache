<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRappelsTable extends Migration
{
    public function up()
    {
        Schema::create('rappels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_groupe_id')->constrained('tache_groupes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->dateTime('rappel_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rappels');
    }
}
