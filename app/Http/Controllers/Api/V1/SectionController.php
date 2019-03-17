<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Section;

use App\Transformers\SectionTransformer;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sections = null;
        $filters = $request->input('filters');
        if($filters && isset($filters['academic_year']) && isset($filters['semester'])) {
          $sections = Section::where([
            'academic_year' => $filters['academic_year'],
            'semester' => $filters['semester']
          ])
          ->orderBy('academic_year', 'desc');

          $sectionsCount = clone $sections;
          $sectionsCount = $sectionsCount->count();

          $sections = $sections->paginate($request->input('length'));

        }

        return $this->response->paginator($sections, new SectionTransformer);

        return [
          'draw' => $request->input('draw'),
          'recordsTotal' => $sectionsCount,
          'recordsFiltered' => $sectionsCount,
          'data' =>   $sections
        ];
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
    public function store(Request $request)
    {
        return Section::create([
          'academic_year' => $request->input('academic_year'),
          'semester' => $request->input('semester'),
          'name' => $request->input('name'),
          'subject_id' => $request->input('subject_id')
        ]);
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
