<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDescriptionColumnOnMemoryTable extends Migration
{
    /**
     * Run the migrations.
     * change the table memory column description, because the description
     * was limited at 255 chars
     * @return void
     */
    public function up()
    {
        //update field description in memory table, because it was limited to 255 char
        //we had to create a new migration, because we should never modify a migration
        Schema::table('memories', function (Blueprint $table) {
            $table->longText('description')->change();
        });
    }

}
