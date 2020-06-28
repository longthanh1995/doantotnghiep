<?php

namespace App\Http\Requests\DoctorCollege;

use App\Http\Requests\Request;

class DoctorCollegeRequest extends Request
{
    /**
     * @var string
     */
    protected $errorBag = 'collegeForm';

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
            'name' => 'required|min:3',
            'date_of_graduation' => 'required|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
