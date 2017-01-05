<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('rank_id');
            $table->string('name');
            $table->integer('staff');
            $table->integer('union_id');
            $table->integer('plenet_id');

            $table->boolean('alive');

            $table->integer('gold');
            $table->integer('fuel');
            $table->integer('power');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fleets');
    }
}
