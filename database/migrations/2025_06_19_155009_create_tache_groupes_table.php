<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacheGroupesTable extends Migration
{
    public function up()
    {
        Schema::create('tache_groupes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu');
            $table->dateTime('date_limite');
            $table->foreignId('groupe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // auteur de la tâche
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tache_groupes');
    }
}
