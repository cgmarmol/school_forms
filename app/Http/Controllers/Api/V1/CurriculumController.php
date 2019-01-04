<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCurriculumRequest;
use App\Models\Curriculum;
use App\Transformers\CurriculumTransformer;

class CurriculumController extends Controller
{
    /**
     * Show all curricula
     *
     * Get a JSON representation of all the curricula.
     *
     * @Get("/")
     * @Versions({"v1"})
     */
    public function index(Request $request)
    {
      $curricula = Curriculum::orderBy('course_code', 'asc')
        ->offset($request->input('start'))
        ->limit($request->input('length'))
        ->get();

      // subjects link
      // foreach($curricula as &$curriculum) {
      //   $curriculum->action_links = '<a href="'.url("curricula/{$curriculum->id}/subjects").'"><i class="fa fa-book"></i></a>';
      //   unset($curriculum);
      // }

      return [
        'draw' => $request->input('draw'),
        'recordsTotal' => Curriculum::all()->count(),
        'recordsFiltered' => Curriculum::all()->count(),
        'data' => $curricula
      ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurriculumRequest $request)
    {
      $newCurriculum = Curriculum::create($request->all());

      if($newCurriculum) {
        return $this->response->item(
          $newCurriculum,
          new CurriculumTransformer,
          ['key' => 'curriculum']
        );
      }

      return null;
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
