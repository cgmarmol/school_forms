<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Person;
use App\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $students = Student::all();

      return $students;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $person = Person::create([
        'first_name' => $request->input('first_name'),
        'middle_name' => $request->input('middle_name'),
        'last_name' => $request->input('last_name'),
        'gender' => $request->input('gender'),
        'birth_date' => $request->input('birth_date')
      ]);

      $person->student()->create([
        'LRN' => $request->input('LRN')
      ]);

      $person->addresses()->create([
        'description' => $request->input('address_description'),
        'barangay' => $request->input('address_barangay'),
        'municipality_city' => $request->input('address_municipality_city'),
        'province' => $request->input('address_province')
      ]);

      return $person->student;
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
      $student = Student::findOrFail($id);
      $student->delete();

      return $student;
    }
}
