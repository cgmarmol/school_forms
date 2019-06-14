<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use App\Transformers\StudentTransformer;

class SectionStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Section $section)
    {
      $students = $section->students;
      $studentIDs = $students->pluck('id');

      if($studentIDs) {
        $students = Student::select('students.*')
          ->join('people', 'students.person_id', '=', 'people.id')
          ->orderBy('people.gender', 'asc')
          ->orderBy('people.last_name', 'asc')
          ->whereIn('students.id', $studentIDs)
          ->paginate($request->input('length'));

        $transformer = new StudentTransformer;
        $transformer->sectionId = $section->id;

        return $this->response->paginator($students, $transformer);
      }

      return null;
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
    public function store(Request $request, Section $section)
    {
        $student = Student::findOrFail($request->input('student_id'));
        $section->students()->attach($student);

        return $student;
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
    public function destroy(Section $section, Student $student)
    {
        $student->attendances()->where('section_id', $section->id)->delete();
        $section->students()->detach($student);

        return $student;
    }


    public function storeAttendance(Request $request, Section $section, Student $student)
    {
        $entryDate = $request->input('entry_date');
        $entryCode = $request->input('entry_code');

        $attendance = $student->attendances()->where([
          'section_id' => $section->id,
          'entry_date' => $entryDate
        ])->first();

        if($attendance) {
          $attendance->entry_code = $entryCode;
          $attendance->save();
        } else {
          $attendance = $student->attendances()->create([
            'section_id' => $section->id,
            'entry_date' => $entryDate,
            'entry_code' => $entryCode
          ]);
        }

        return $attendance;
    }
}
