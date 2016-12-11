<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fight_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fleet_id');
            $table->date('date');
            $table->integer('enemy_encounter');
            $table->integer('enemy_victory');
            $table->integer('enemy_defeat');
            $table->integer('enemy_dogfall');
            $table->integer('enemy_kill');
            $table->integer('linkage')->comment('联动作战');
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
        Schema::drop('fight_reports');
    }
}
