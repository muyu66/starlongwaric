<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleetTechTechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet_tech_teches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc');
            $table->integer('per_fee');
            $table->integer('per_power');
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
        Schema::drop('fleet_tech_teches');
    }
}
