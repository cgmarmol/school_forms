<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_students', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('section_id')->unsigned()->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->integer('grade')->unsigned()->nullable();

            $table->foreign('section_id')
              ->references('id')->on('sections')
              ->onDelete('cascade')
              ->onUpdate('cascade');

            $table->foreign('student_id')
              ->references('id')->on('students')
              ->onDelete('cascade')
              ->onUpdate('cascade');

            $table->unique(['section_id', 'student_id']);

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
        Schema::dropIfExists('section_students');
    }
}
