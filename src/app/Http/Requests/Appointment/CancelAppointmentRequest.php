<?php

namespace App\Http\Requests\Appointment;

use App\Http\Requests\Request;

class CancelAppointmentRequest extends Request
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
            'cancel_reason' => 'present',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
