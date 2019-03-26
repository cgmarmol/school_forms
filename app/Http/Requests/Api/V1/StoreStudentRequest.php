<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $studentType = $this->input('student_type');

        return [
          'enrollment_schedule' => 'required',
          'student_id' => $studentType == 'old' ? 'required' : '',
          'first_name' => $studentType == 'new' ? 'required' : '',
          'last_name' => $studentType == 'new' ? 'required' : '',
        ];
    }
}
