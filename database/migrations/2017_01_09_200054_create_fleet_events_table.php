<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet_events', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fleet_id');
            $table->integer('standard_id');
            $table->boolean('status');
            $table->integer('commander');

            $table->timestamps();

            $table->index(['fleet_id', 'status']);

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
        Schema::drop('events');
    }
}
