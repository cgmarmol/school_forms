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

$api->version('v1', function($api) {

  $api->get('/', function() {
    return 'School Forms API';
  });

  $api->resource('students', 'App\Http\Controllers\Api\V1\StudentController');
  $api->resource('subjects', 'App\Http\Controllers\Api\V1\SubjectController');
  $api->resource('curricula', 'App\Http\Controllers\Api\V1\CurriculumController');

});
