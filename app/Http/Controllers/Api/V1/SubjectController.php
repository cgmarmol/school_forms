<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreSubjectRequest;
use App\Models\Subject;
use App\Transformers\SubjectTransformer;

class SubjectController extends Controller
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
      return [
        'draw' => $request->input('draw'),
        'recordsTotal' => Subject::all()->count(),
        'recordsFiltered' => Subject::all()->count(),
        'data' => Subject::orderBy('code', 'asc')
          ->offset($request->input('start'))
          ->limit($request->input('length'))
          ->get()
      ];
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
        //
    }
}
