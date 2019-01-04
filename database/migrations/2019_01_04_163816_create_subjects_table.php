<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('curriculum_id')->unsigned()->nullable();
            $table->string('level');
            $table->tinyInteger('default_semester')->nullable();
            $table->string('code');
            $table->string('title');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('curriculum_id')
              ->references('id')->on('curricula')
              ->onDelete('cascade')
              ->onUpdate('cascade');

            $table->unique(['curriculum_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
