<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCurriculumRequest extends FormRequest
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
        return [
          'course_code' => 'required',
          'description' => 'required',
          'academic_year_effectivity' => 'required'
        ];
    }
}
