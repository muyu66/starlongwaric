<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('boss_id');
            $table->boolean('is_hero');

            $table->string('name');
            $table->string('desc');
            $table->integer('character')
                ->comment('0粗鲁,1好战,2冷静');
            $table->boolean('is_commander');

            $table->integer('job')
                ->comment('0警卫,1工程师,2指挥家,3绝地武士');
            $table->integer('job_ability');

            $table->integer('intelligence');
            $table->integer('loyalty');

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
        Schema::drop('staff');
    }
}
