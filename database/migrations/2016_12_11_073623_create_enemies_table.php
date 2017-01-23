<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnemiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enemies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rank_id');
            $table->string('name');
            $table->integer('staff');
            $table->integer('union_id');
            $table->integer('planet_id');
            $table->integer('gold');
            $table->integer('fuel');
            $table->integer('power');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enemies');
    }
}
