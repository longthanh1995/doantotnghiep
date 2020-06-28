<?php namespace App\Http\Requests\ConsultReason;

use App\Http\Requests\Request;

class DeleteConsultReasonRequest extends Request
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
        return [];
    }

    public function messages()
    {
        return [
        ];
    }
}