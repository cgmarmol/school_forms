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
            $table->increments('id');
            $table->string('academic_year');
            $table->tinyInteger('semester');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_open')->default(false);

            $table->timestamps();

            $table->unique(['academic_year', 'semester']);
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
