<?php
namespace App\Transformers;

use App\Models\Student;
use App\Models\Person;
use League\Fractal\TransformerAbstract;

class StudentTransformer extends TransformerAbstract
{
    public $availableIncludes = [
      'sections'
    ];

    public $academicYear = null;
    public $semester = null;

    public function transform(Student $student) {

        $person = $student->person;

        return [
          'id' => (int) $student->id,
          'LRN' => (string) $student->LRN,
          'first_name' => $person->first_name,
          'middle_name' => $person->middle_name,
          'last_name' => $person->last_name
        ];
    }

    public function includeSections(Student $student) {

      if(isset($this->academicYear) && isset($this->semester)) {
        $sections = $student->sections()->where('academic_year', '=', $this->academicYear)
          ->where('semester', '=', $this->semester)
          ->get();
      } else {
        $sections = $student->sections;
      }

      if($sections) {
        return $this->collection($sections, new SectionTransformer());
      }

      return null;
    }
}
