<?php

namespace App\Http\Requests\Appointment;

use App\Http\Requests\Request;

class ConfirmAppointmentRequest extends Request
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
        $listsTime = \DateTimeHelper::getTimeOptionsForDoctor();

        return [
            'start_time' => 'required|in:'.implode(',', array_keys($listsTime)),
            'end_time' => 'required|in:'.implode(',', array_keys($listsTime)).'|greater_than_field:start_time',
            'appointment_date' => 'required|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
