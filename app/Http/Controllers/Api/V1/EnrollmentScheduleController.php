<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EnrollmentSchedule;

class EnrollmentScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      return [
        'draw' => $request->input('draw'),
        'recordsTotal' => EnrollmentSchedule::all()->count(),
        'recordsFiltered' => EnrollmentSchedule::all()->count(),
        'data' => EnrollmentSchedule::orderBy('academic_year', 'desc')
          ->orderBy('semester', 'desc')
          ->get()
      ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return EnrollmentSchedule::create($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = explode('_', $id);
        $academic_year = $id[0];
        $semester = $id[1];
        $enrollment_schedule = EnrollmentSchedule::where([
            'academic_year' => $academic_year,
            'semester' => $semester
          ])->first();

        return $enrollment_schedule;
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
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
