<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'bindings'], function($api) {
  $api->get('/', function() {
    return 'School Forms API';
  });
  $api->post('login', 'App\Http\Controllers\Api\V1\AuthenticateController@login');
});

$api->version('v1', ['middleware' => 'bindings', 'api.auth'], function($api) {

  // refresh token
  $api->get('authentication/refresh', 'App\Http\Controllers\Api\V1\AuthenticateController@token');

  // authenticated user
  $api->get('authentication/user', function() {
    return app('Dingo\Api\Auth\Auth')->user();
  });

  // authentication --- logout
  $api->get('authentication/logout', 'App\Http\Controllers\Api\V1\AuthenticateController@logout');

  $api->resource('students', 'App\Http\Controllers\Api\V1\StudentController');
  $api->resource('subjects', 'App\Http\Controllers\Api\V1\SubjectController');
  $api->resource('curricula', 'App\Http\Controllers\Api\V1\CurriculumController');

  $api->resource('curricula/{id}/subjects', 'App\Http\Controllers\Api\V1\CurriculumSubjectController');

  $api->resource('enrollment-schedules', 'App\Http\Controllers\Api\V1\EnrollmentScheduleController');
  $api->get('active-enrollment-schedules', 'App\Http\Controllers\Api\V1\EnrollmentScheduleController@activeEnrollmentSchedules');

  $api->resource('sections', 'App\Http\Controllers\Api\V1\SectionController');
  $api->resource('sections.students', 'App\Http\Controllers\Api\V1\SectionStudentController');

});
