<?php

use Illuminate\Database\Seeder;

class CurriculaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	      $course = App\Models\Course::where('code', '=', 'K to 12')->first();
	      $course->curricula()->delete();
       $course->curricula()->saveMany(
	         factory(App\Models\Curriculum::class,10)->make()
	      );
    }
}
