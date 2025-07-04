<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupeToTachesTable extends Migration
{
    public function up()
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->unsignedBigInteger('groupe_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('assignee_id')->nullable()->after('groupe_id');

            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('set null');
            $table->string('priorite')->default('moyenne')->change();
        });
    }

    public function down()
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign(['groupe_id']);
            $table->dropForeign(['assignee_id']);
            $table->dropColumn(['groupe_id', 'assignee_id']);
        });
    }
}
