<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Person;
use App\Transformers\UserTransformer;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::all();

      return $this->response->collection(
        $users,
        new UserTransformer,
        ['key' => 'users']
      );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $person = Person::create([
          'first_name' => $request->input('first_name'),
          'middle_name' => $request->input('middle_name'),
          'last_name' => $request->input('last_name'),
          'gender' => $request->input('gender'),
        ]);

        $person->user()->create([
          'email' => $request->input('email'),
          'password' => md5('123456'),
        ]);

        return $this->response->item(
          $person->user,
          new UserTransformer,
          ['key' => 'user']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $person = $user->person;
        $user->delete();
        $person->delete();

        return $this->response->item(
          $user,
          new UserTransformer,
          ['key' => 'user']
        );
    }
}
