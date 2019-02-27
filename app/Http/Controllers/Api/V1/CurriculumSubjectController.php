<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreSubjectRequest;
use App\Models\Curriculum;
use App\Models\Subject;

class CurriculumSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $curriculum = Curriculum::find($id);

        if($curriculum) {
          $subjects = $curriculum->subjects()
          ->offset($request->input('start'))
          ->limit($request->input('length'))
          ->orderBy('title', 'asc')
          ->get();
          return [
            'draw' => $request->input('draw'),
            'recordsTotal' => $curriculum->subjects->count(),
            'recordsFiltered' => $curriculum->subjects->count(),
            'data' => $subjects
          ];
        }

        return [];
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
    public function store(StoreSubjectRequest $request, $id)
    {
      $curriculum = Curriculum::find($id);

      if($curriculum) {
        $subject = Subject::create([
          'default_semester'       => $request->input('default_semester'),
          'level'       => $request->input('subject_level'),
          'code'        => $request->input('subject_code'),
          'title'       => $request->input('subject_title'),
          'description' => $request->input('subject_description')
        ]);

        return $curriculum->subjects()->save($subject);
      }

      return [];
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
