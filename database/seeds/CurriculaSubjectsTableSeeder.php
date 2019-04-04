<?php

use Illuminate\Database\Seeder;

class CurriculaSubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $curricula = App\Models\Curriculum::all();
       if($curricula->count()>0){
          $curricula->each(function($curriculum){
             $curriculum->subjects()->saveMany(
                   factory(App\Models\Subject::class,5)->make()
                );
          });
       }
    }
}
