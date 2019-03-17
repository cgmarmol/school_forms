<?php
namespace App\Transformers;

use App\Models\Section;
use League\Fractal\TransformerAbstract;

class SectionTransformer extends TransformerAbstract
{
    public $availableIncludes = [
      'subject'
    ];

    public function transform(Section $section) {
        return [
          'id' => (int) $section->id,
          'name' => (string) $section->name,
          'academic_year' => (string) $section->academic_year,
          'semester'=> $section->semester,
          'number_students' => $section->students->count()
        ];
    }

    public function includeSubject(Section $section) {
        return $this->item($section->subject, new SubjectTransformer);
    }
}
