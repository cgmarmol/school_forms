<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubjectRequest extends FormRequest
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
        $curriculum_id = $this->route()->parameters('id');
        $subject_code = $this->input('subject_code');

        return [
          'default_semester' => 'nullable',
          'subject_level' => 'required',
          'subject_code' => [
            'required',
            function($attribute, $value, $fail) use ($curriculum_id, $subject_code) {
              $test = \App\Models\Subject::where('curriculum_id', $curriculum_id)
                ->where('code', $subject_code)->get()->count();
              if($test) {
                $fail('The ' . str_replace('_', ' ', $attribute) . ' has already been taken.');
              }
            }
          ],
          'subject_title' => 'required',
          'subject_description' => 'nullable'
        ];
    }
}
