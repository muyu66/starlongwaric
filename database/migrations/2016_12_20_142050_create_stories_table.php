<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chapter');
            $table->text('content');
            $table->integer('timeline');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('stories');
    }
}
