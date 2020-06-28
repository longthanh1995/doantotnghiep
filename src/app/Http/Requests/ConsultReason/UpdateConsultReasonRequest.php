<?php namespace App\Http\Requests\ConsultReason;

use App\Http\Requests\Request;

class UpdateConsultReasonRequest extends Request
{
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
            'reason' => 'string',
            'appointment_type_id' => 'numeric',
            'parent_id' => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}