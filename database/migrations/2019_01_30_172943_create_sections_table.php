<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');

            $table->string('academic_year');
            $table->tinyInteger('semester');
            $table->string('name');
            $table->integer('subject_id')->unsigned()->nullable();

            $table->foreign('subject_id')
              ->references('id')->on('subjects')
              ->onDelete('cascade')
              ->onUpdate('cascade');

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
        Schema::dropIfExists('sections');
    }
}
