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
        $students = App\Models\Student::where('id', '>', 0);
        foreach($students as $student) {
          $person = $student->person;
          $student->delete();
          $person->delete();
        }

	      factory(App\Models\Person::class, 10)->create()->each(function($u) {
          $u->student()->save(factory(App\Models\Student::class)->make());
       });
    }
}
