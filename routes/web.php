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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/enroll', function () {
    return view('enroll/index');
});


Route::get('/settings/subjects', function() {
    return view('settings/subjects/index');
});

Route::get('/settings/curricula', function() {
    $courses = App\Models\Course::all();
    return view('settings/curricula/index', [
      'courses' => $courses
    ]);
});
