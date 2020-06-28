<?php

namespace App\Http\Requests\Appointment;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

class FilterSearchRequest extends Request
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
            'patientName' => '', // nothing
            'patientId' => 'numeric',
            'clinic' => '', // Nothing
            'appointmentBooking' => 'date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    /** @inheritdoc */
    protected function getRedirectUrl()
    {
        $current = \URL::current();

        return $current;
    }
}
