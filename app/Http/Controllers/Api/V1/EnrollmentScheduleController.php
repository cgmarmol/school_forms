<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EnrollmentSchedule;

use App\Transformers\EnrollmentScheduleTransformer;

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
        $academicYear = $request->input('academic_year');
        $semester = $request->input('semester');
        $duration = $request->input('duration');
        $duration = explode('-', $duration);

        $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($duration[0]));
        $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($duration[1]));

        return EnrollmentSchedule::create([
          'academic_year' => $academicYear,
          'semester' => $semester,
          'start_date' => $startDate->format('Y-m-d'),
          'end_date' => $endDate->format('Y-m-d')
        ]);
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
        $temp = explode('_', $id);
        $schoolYear = $temp[0];
        $semester = $temp[1];

        $enrollmentSchedule = EnrollmentSchedule::where('academic_year', '=', $schoolYear)
          ->where('semester', '=', $semester)
          ->first();

        $enrollmentSchedule->is_open = $enrollmentSchedule->is_open ? 0 : 1;
        $enrollmentSchedule->save();

        return $enrollmentSchedule;
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

    public function activeEnrollmentSchedules()
    {
        $enrollmentSchedules = EnrollmentSchedule::orderBy('academic_year', 'desc')
          ->where('is_open', '=', 1)
          ->orderBy('semester', 'desc')
          ->get();

        if($enrollmentSchedules) {
          return $this->response->collection($enrollmentSchedules, new EnrollmentScheduleTransformer(), ['key' => 'enrollment-schedules']);
        }

        return null;
    }
}
