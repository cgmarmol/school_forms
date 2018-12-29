<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curricula', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_code');
            $table->string('description');
            $table->string('academic_year_effectivity');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('course_code')
              ->references('code')->on('courses')
              ->onDelete('cascade')
              ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curricula');
    }
}
