<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoutineRequest extends FormRequest
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
        //|mimes:jpeg,png,jpg,doc,docx,pdf
        return [
            'name'  =>  'required|min:3|max:20',
            'file'  =>   'required|max:2048|mimes:jpeg,png,jpg,doc,docx,pdf',
            'description'   =>  'required|max:255',
            'level_id'  =>  'required|numeric'
        ];
    }
}
