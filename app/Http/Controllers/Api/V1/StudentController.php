<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Student;
use App\Transformers\StudentTransformer;
use App\Http\Requests\Api\V1\StoreStudentRequest;

/**
* @Resource("Students")
*/
class StudentController extends Controller
{
    /**
     * Show all students
     *
     * Get a JSON representation of all the registered students.
     *
     * @Get("/")
     * @Versions({"v1"})
     */
    public function index(Request $request)
    {
      $term = $request->input('term');

      $students = null;
      if(isset($term) && strlen($term) > 0) {
        $students = Student::where('LRN', 'like', '%'.$term.'%')
          ->orWhereHas('person', function($query) use ($term) {
            $query->where('last_name', 'like', '%'.$term.'%')
              ->orWhere('first_name', 'like', '%'.$term.'%');
          })
          ->select(['students.*'])
          ->join('people', 'people.id', '=', 'students.person_id', 'inner')
          ->orderBy('people.last_name', 'asc')
          ->get();
      }

      if($students) {
        return $this->response->collection(
          $students,
          new StudentTransformer,
          ['key' => 'students']
        );
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
    public function store(StoreStudentRequest $request)
    {
      $enrollmentSchedule = $request->input('enrollment_schedule');
      $enrollmentSchedule = explode('_', $enrollmentSchedule);
      $academicYear = $enrollmentSchedule[0];
      $semester = $enrollmentSchedule[1];
      $student = null;

      if($request->input('student_type') == 'new')
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

        $student = $person->student;
      } else {
        $student = Student::findOrFail($request->input('student_id'));
      }

      return $this->response->item(
        $student,
        new StudentTransformer(),
        ['key' => 'student']
      )->setMeta([
        'academic_year' => $academicYear,
        'semester' => $semester
      ]);
    }

    /**
     * Show student
     *
     * Get a JSON representation of the registered student.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Parameters({
     *  @Parameter("id", type="integer", required=true, description="Student id reference.")
     * })
     */
    public function show(Request $request, $id)
    {
      $student = Student::findOrFail($id);

      $filters = $request->input('filters');
      $studentTransformer = new StudentTransformer();
      $studentTransformer->academicYear = isset($filters['academic_year']) ? $filters['academic_year'] : null;
      $studentTransformer->semester = isset($filters['semester']) ? $filters['semester'] : null;

      if($student) {
        return $this->response->item($student, $studentTransformer, ['key' => 'student']);
      }

      return null;
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
