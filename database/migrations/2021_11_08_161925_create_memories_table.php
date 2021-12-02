<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memories', function (Blueprint $table) {
            $table->id();           //primary key
            $table->timestamps();   //audit field
            $table->string('name');
            $table->timestamp('visited_date')->useCurrent();
            $table->point('location',4326); // srid 4326 represents spatial data using longitude and latitude coordinates on the Earth's surface as defined in the WGS84 standard
            $table->string('description')->nullable();
            //https://medium.com/maatwebsite/the-best-way-to-locate-in-mysql-8-e47a59892443
            //https://www.cockroachlabs.com/docs/stable/srid-4326.html

            //index
             $table->spatialIndex('location');



            //add foreign key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memories');
    }
}
