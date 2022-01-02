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
