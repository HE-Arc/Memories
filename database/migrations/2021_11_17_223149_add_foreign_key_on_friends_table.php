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
        //add relation for users
        //each users can be friends with n others friends
        //relation N:N
        //a user can be friends with the same friends only 1 time
        Schema::table('friends', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('friend_id')->constrained("users")->onDelete('cascade');
            $table->unique(['user_id','friend_id'],'uk1');
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
