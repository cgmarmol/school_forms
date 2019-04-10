<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = App\User::all();
        foreach($users as $user) {
          $person = $user->person;
          $user->delete();
          $person->delete();
        }

	      factory(App\Models\Person::class, 100)->create()->each(function($u) {
          $u->user()->save(factory(App\User::class)->make());
       });
    }
}
