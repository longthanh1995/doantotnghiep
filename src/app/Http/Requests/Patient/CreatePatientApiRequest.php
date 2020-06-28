<?php

namespace App\Http\Requests\Patient;

use App\Http\Requests\Request;
use App\Models\Patient;

class CreatePatientApiRequest extends Request
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
            'first_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:1|max:255',
            'gender' => 'required|in:'.implode(',', array_keys(Patient::LIST_GENDERS)),
            'date_of_birth' => 'required|date_format:d/m/Y',
            'email' => 'email',
            'phone_number' => '',
            'phone_country_code' => '',
            'address_street' => '',
            'address_city' => '',
            'issue_country_id' => 'integer',
            'address_zip' => '',
            'id_number' => 'required|min:4|max:32',
            'clinic_id' => 'integer'
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
