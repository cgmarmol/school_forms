<?php
namespace App\Transformers;

use App\Models\EnrollmentSchedule;
use App\Models\Student;
use App\Models\Person;
use App\Models\Section;
use App\Models\Attendance;
use League\Fractal\TransformerAbstract;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StudentTransformer extends TransformerAbstract
{
    public $availableIncludes = [
      'sections',
      'attendances'
    ];

    public $academicYear = null;
    public $semester = null;
    public $sectionId = null;

    public function transform(Student $student) {

        $person = $student->person;

        $fields = [
          'id' => (int) $student->id,
          'LRN' => (string) $student->LRN,
          'first_name' => $person->first_name,
          'middle_name' => $person->middle_name,
          'last_name' => $person->last_name,
          'gender' => $person->gender
        ];

        if($this->sectionId) {
          $attendances = $student->attendances->where('section_id', $this->sectionId);
          $fields['lates'] = $attendances->where('entry_code', 'L')->count();
          $fields['absences'] = $attendances->where('entry_code', 'A')->count();
        }

        return $fields;
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

    public function includeAttendances(Student $student)
    {
       $section = Section::findOrFail($this->sectionId);
       $attendances = $student->attendances->where('section_id', $section->id);

       $enrollmentSchedule = EnrollmentSchedule::where('academic_year', $section->academic_year)
         ->where('semester', $section->semester)
         ->first();

       $start = Carbon::createFromFormat('Y-m-d', $enrollmentSchedule->start_date);
       $end = Carbon::createFromFormat('Y-m-d', $enrollmentSchedule->end_date);
       $period = CarbonPeriod::create($start->format('Y-m-d'), $end->endOfMonth()->format('Y-m-d'));

       $ledger = collect();
       foreach($period as $date) {
          $attendance = $attendances->where('entry_date', $date->format('Y-m-d'))->first();
          if($attendance) {
            $ledger->push($attendance);
          } else {

            if($date->isWeekend()) continue;

            $ledger->push(Attendance::make([
              'section_id' => $section->id,
              'entry_date' => $date->format('Y-m-d'),
              'entry_code' => ''
            ]));
          }
       }

       if($attendances) {
         return $this->collection($ledger, new AttendanceTransformer());
       }

       return null;
    }


}
