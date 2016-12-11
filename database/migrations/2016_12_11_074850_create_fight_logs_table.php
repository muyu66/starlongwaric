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
            $table->char('result', 1)->comment('0战败,1胜利,2和局');
            $table->json('booty');
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
        Schema::drop('fight_logs');
    }
}
