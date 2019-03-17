<?php
namespace App\Transformers;

use App\Models\Subject;
use League\Fractal\TransformerAbstract;

class SubjectTransformer extends TransformerAbstract
{
    public function transform(Subject $subject) {
        return [
          'id' => (int) $subject->id,
          'code' => (string) $subject->code,
          'title' => $subject->title,
          'description' => $subject->description,
          'level' => $subject->level
        ];
    }
}
