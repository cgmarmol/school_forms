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
        return [
          'code' => 'required|unique:subjects',
          'title' => 'required',
          'description' => 'nullable'
        ];
    }
}
