<?php

namespace App\Http\Requests\DoctorQualification;

use App\Http\Requests\Request;

class DoctorQualificationRequest extends Request
{
    /**
     * @var string
     */
    protected $errorBag = 'qualificationForm';

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
            'name' => 'required|min:1|max:45',
            'issuer' => 'required|min:1|max:100',
            'issued_time' => 'required|date_format:Y',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
