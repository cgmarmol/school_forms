<?php

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       App\Models\Section::where('id', '>', 0)->delete();
       $curriculum = App\Models\Curriculum::all()->first();
       $subjects = $curriculum->subjects;
       if($subjects->count()>0){
          $subjects->each(function($subject){
             $subject->sections()->saveMany(
                   factory(App\Models\Section::class,3)->make()
                );
          });
       }
    }
}
