<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CoursesTableSeeder::class);
       	$this->call(StudentsTableSeeder::class);
       	$this->call(TeachersTableSeeder::class);
	      $this->call(CurriculaTableSeeder::class);
	      $this->call(CurriculaSubjectsTableSeeder::class);
	      $this->call(SectionsTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
    }
}
