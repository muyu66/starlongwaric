<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fight_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('my_id');
            $table->integer('enemy_id');
            $table->integer('my_power');
            $table->integer('enemy_power');
            $table->boolean('result')->comment('-1战败,0平局,1胜利');
            $table->json('booty');
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
        Schema::drop('fight_logs');
    }
}
