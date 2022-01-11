<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemoryPublishedMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add a new field to the memories table
        //we had to create a new migration, because we should never modify a migration
        //this new field indicate the status of the memory :
        //private --> only the memory's user can see it
        //friends-only --> only the friends of this user and this user can see his memories
        //public --> everybody can see our memories
        Schema::table('memories', function (Blueprint $table) {
            $table->enum('publishing', ['private', 'public', 'friends-only'])->default('private');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memories', function (Blueprint $table) {
            $table->dropColumn('publishing');
        });
    }
}
