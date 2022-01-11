<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoryPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //new table to store the pictures of a memory
        Schema::create('memory_pictures', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('picture_name')->unique(); //picture's name, unique because potential directory conflit

            //order to indicate in the slideshow the order of the pictures, false -> not auto increment, true -> unsigned
            $table->integer('order', false, true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memory_pictures');
    }
}
