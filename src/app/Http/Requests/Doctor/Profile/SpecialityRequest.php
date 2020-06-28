<?php

namespace App\Http\Requests\Doctor\Profile;

use App\Http\Requests\BaseRequest;
use App\Repositories\PatientConditionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SpecialityRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $errorBag = 'specialityForm';

    /**
     * @var PatientConditionRepositoryInterface
     */
    protected $patientConditionRepository;

    /**
     * SpecialityRequest constructor.
     *
     * @param PatientConditionRepositoryInterface $patientConditionRepository
     */
    public function __construct(PatientConditionRepositoryInterface $patientConditionRepository)
    {
        $this->patientConditionRepository = $patientConditionRepository;
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
        /** @var Collection $conditionsCollection */
        $conditionsCollection = $this->patientConditionRepository->all();
        $listConditions = $conditionsCollection->pluck('id')->toArray();

        return [
            'conditions' => 'required|min:1',
            'conditions.*' => 'in:'.implode(',', $listConditions),
        ];
    }

    public function messages()
    {
        return [];
    }
}
