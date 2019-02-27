<?php

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Course::whereNotNull('code')->delete();
        App\Models\Course::create([
          'code' => 'K to 12',
          'description' => 'Kindergarten and 12 years of basic education'
        ]);
    }
}
