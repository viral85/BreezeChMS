<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email_address', 255)->unique();
            $table->integer('group_id');
            $table->timestamps();
            $table->tinyInteger('status')->default(1)->nullable()->comment('1 - Active , 2 - Archived, 3 - Deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
