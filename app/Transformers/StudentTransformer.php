<?php
namespace App\Transformers;

use App\Models\Student;
use App\Models\Person;
use League\Fractal\TransformerAbstract;

class StudentTransformer extends TransformerAbstract
{
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
}
