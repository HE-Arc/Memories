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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('friend_id')->constrained()->onDelete('cascade');
            $table->unique(['user_id1','friend_id'],'uk1');
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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['friend_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('friend_id');
        });
    }
}
