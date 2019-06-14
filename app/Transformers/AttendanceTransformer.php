<?php
namespace App\Transformers;

use App\Models\Attendance;
use League\Fractal\TransformerAbstract;

class AttendanceTransformer extends TransformerAbstract
{
    public $availableIncludes = [
    ];

    public function transform(Attendance $attendance) {
        return [
          'id' => (int) $attendance->id,
          'date' => $attendance->entry_date,
          'code' => $attendance->entry_code
        ];
    }

}
