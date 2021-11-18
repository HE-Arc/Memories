<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyOnFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->foreignId('user_id1')->constrained()->onDelete('cascade');
            $table->foreignId('user_id2')->constrained()->onDelete('cascade');
            $table->unique(['user_id1','user_id2'],'uk1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->dropForeign(['user_id1']);
            $table->dropForeign(['user_id2']);
            $table->dropColumn('user_id1');
            $table->dropColumn('user_id2');
        });
    }
}
