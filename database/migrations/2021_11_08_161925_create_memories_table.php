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
            $table->bigInteger('user_id')->unsigned();   //foreign key
            $table->string('name');
            $table->timestamp('visited_date')->useCurrent();
            $table->point('location',4326); // srid 4326 represents spatial data using longitude and latitude coordinates on the Earth's surface as defined in the WGS84 standard
            $table->string('description')->nullable();
            //https://medium.com/maatwebsite/the-best-way-to-locate-in-mysql-8-e47a59892443
            //https://www.cockroachlabs.com/docs/stable/srid-4326.html

            //index
            $table->spatialIndex('location');



            //add foreign key
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');


           $table->unique(['name','user_id'],'uk1');
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
