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
      factory(App\Models\Person::class, 100)->create()->each(function($u) {
        $u->student()->save(factory(App\Models\Student::class)->make());
      });
    }
}
