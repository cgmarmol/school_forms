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
    return view('enroll/index', []);
});

Route::get('/enroll/{academic_year}/{semester}/{studentId}', function ($academic_year, $semester, $studentId) {
    return view('enroll/show', [
      'academic_year' => $academic_year,
      'semester' => $semester,
      'studentId' => $studentId
    ]);
});

Route::get('/sections', function() {
    return view('sections/index', []);
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
  Route::get('user-accounts', function() {
    return view('settings/user-accounts/index');
  });
});

Route::get('test', function() {
  $subject = App\Models\Subject::where('code', 'MATH_G01')->first();
  $curriculum = App\Models\Curriculum::find(1);

  $curriculum->subjects()->detach();
  $curriculum->subjects()->save($subject);

  return $curriculum->subjects;
});


Route::get('fake-account', function() {
  $user = App\User::create([
    'name' => 'Dave Medrano',
    'email' => 'evadonardem@gmail.com',
    'password' => md5('123456')
  ]);

  return $user;
});
