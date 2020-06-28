<?php

namespace App\Http\Requests\Doctor\Profile;

use App\Http\Requests\BaseRequest;

class EditAvatarRequest extends BaseRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'avatarForm';

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
        $maxSize = 12000;

        return [
            'avatar' => 'required|image|max:'.$maxSize,
        ];
    }

    public function messages()
    {
        return [];
    }
}
