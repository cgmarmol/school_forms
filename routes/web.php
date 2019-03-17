<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', function () {
    return view('login');
});

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/enroll', function () {
    $openEnrollmentSchedules = App\Models\EnrollmentSchedule::where('is_open', '=', 1)
        ->orderBy('academic_year', 'desc')
        ->orderBy('semester', 'desc')
        ->get();

    $students = App\Models\Student::all();

    return view('enroll/index', [
      'openEnrollmentSchedules' => $openEnrollmentSchedules,
      'students' => $students
    ]);
});

Route::get('/enroll/{academic_year}/{semester}', function ($academic_year, $semester) {
    $openEnrollmentSchedule = App\Models\EnrollmentSchedule::where('is_open', '=', 1)
        ->where('academic_year', '=', $academic_year)
        ->where('semester', '=', $semester)
        ->first();

    $sections = App\Models\Section::where('academic_year', '=', $openEnrollmentSchedule->academic_year)
        ->where('semester', '=', $openEnrollmentSchedule->semester)
        ->get();

    return view('enroll/show', [
      'openEnrollmentSchedule' => $openEnrollmentSchedule,
      'sections' => $sections
    ]);
});

// Settings
Route::prefix('settings')->group(function() {
  Route::get('curricula', function() {
      $courses = App\Models\Course::all();
      return view('settings/curricula/index', [
        'courses' => $courses
      ]);
  });
  Route::get('curricula/{id}/subjects', function($id) {
      $curriculum = App\Models\Curriculum::find($id);
      return view('settings/curricula/subjects/index', [
        'curriculum' => $curriculum
      ]);
  });
  Route::get('enrollment-schedules', function() {
    $courses = App\Models\Course::all();
    $curricula = App\Models\Curriculum::where('course_code', 'K to 12')->get();
    return view('settings/enrollment-schedules/index', [
      'courses' => $courses,
      'curricula' => $curricula
    ]);
  });
  Route::get('sections/{academic_year}/{semester}', function($academic_year, $semester) {
    return view('settings/sections/index', [
      'academic_year' => $academic_year,
      'semester' => $semester
    ]);
  });
});

Route::get('test', function() {
  $subject = App\Models\Subject::where('code', 'MATH_G01')->first();
  $curriculum = App\Models\Curriculum::find(1);

  $curriculum->subjects()->detach();
  $curriculum->subjects()->save($subject);

  return $curriculum->subjects;
});
