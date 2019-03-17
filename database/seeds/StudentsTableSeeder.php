<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	      App\Models\Student::where('id', '>', 0)->delete();
	      App\Models\Person::where('id', '>', 0)->delete();
	      factory(App\Models\Person::class, 500)->create()->each(function($u) {
          $u->student()->save(factory(App\Models\Student::class)->make());
       });
    }
}
