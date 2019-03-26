<?php
namespace App\Transformers;

use App\Models\EnrollmentSchedule;
use League\Fractal\TransformerAbstract;

class EnrollmentScheduleTransformer extends TransformerAbstract
{
    public $availableIncludes = [];

    public function transform(EnrollmentSchedule $enrollmentSchedule) {
        return [
          'id' => (int) $enrollmentSchedule->id,
          'academic_year' => $enrollmentSchedule->academic_year,
          'semester' => $enrollmentSchedule->semester
        ];
    }
}
