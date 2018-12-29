<?php
namespace App\Transformers;

use App\Models\Curriculum;
use League\Fractal\TransformerAbstract;

class CurriculumTransformer extends TransformerAbstract
{
    public function transform(Curriculum $curriculum) {
        return [
          'id' => (int) $curriculum->id,
          'course_code' => (string) $curriculum->course_code,
        ];
    }
}
