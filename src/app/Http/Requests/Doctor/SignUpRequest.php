<?php

namespace App\Http\Requests\Doctor;

use App\Http\Requests\BaseRequest;
use App\Models\Doctor;
use App\Models\ManaUser;

class SignUpRequest extends BaseRequest
{
    public function all()
    {
        $input = parent::all();
        $input = array_map('trim', $input);
        if (isset($input['phone_number'])) {
            $input['phone_number'] = ltrim($input['phone_number'], '0');
        }
        
        return $input;
    }
    
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
            'name'     => 'required|min:3|max:255',
            'email'    => 'required|email|unique:'.ManaUser::getConnectionNameStatic().'.'.ManaUser::getTableName().',email,NULL,id,account_id,2',
            'password' => 'required|min:6',
            'phone_country_code' => 'required|min:2|max:5',
            'phone_number' => 'required|phone_number',
            'country_id' => 'required',
        ];
    }

    public function messages()
    {
        return [];
    }
}
