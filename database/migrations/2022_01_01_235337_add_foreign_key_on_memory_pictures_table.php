<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyOnMemoryPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add relation for memory_picture
        //each memory_picture is associate to 1 memory, 1 memory can have many pictures
        //if we delete a memory, delete each pictures on cascade
        Schema::table('memory_pictures', function (Blueprint $table) {
            $table->foreignId('memory_id')->constrained()->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memory_pictures', function (Blueprint $table) {
            $table->dropForeign(['memory_id']);
            $table->dropColumn('memory_id');
        });
    }
}
