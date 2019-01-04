<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment_schedules', function (Blueprint $table) {
            $table->string('academic_year');
            $table->tinyInteger('semester');
            $table->string('course_code');
            $table->integer('curriculum_id')->unsigned()->nullable();

            $table->foreign('course_code')
              ->references('code')->on('courses')
              ->onDelete('cascade')
              ->onUpdate('cascade');

            $table->foreign('curriculum_id')
              ->references('id')->on('curricula')
              ->onDelete('cascade')
              ->onUpdate('cascade');

            $table->primary(['academic_year', 'semester', 'course_code', 'curriculum_id'], 'enrollment_schedule_primary');

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
        Schema::dropIfExists('enrollment_schedules');
    }
}
