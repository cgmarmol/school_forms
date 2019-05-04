<?php

use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	      App\Models\Teacher::where('id', '>', 0)->delete();
	      App\Models\Person::where('id', '>', 0)->delete();
	      factory(App\Models\Person::class, 10)->create()->each(function($u) {
          $u->student()->save(factory(App\Models\Teacher::class)->make());
          $u->user()->save(factory(App\User::class)->make());
       });
    }
}
