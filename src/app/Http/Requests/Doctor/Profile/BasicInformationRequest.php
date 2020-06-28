<?php

namespace App\Http\Requests\Doctor\Profile;

use App\Http\Requests\BaseRequest;
use App\Models\Doctor;
use App\Repositories\DoctorTitleRepositoryInterface;
use App\Repositories\LanguageRepositoryInterface;
use Illuminate\Support\Collection;

class BasicInformationRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $errorBag = 'basicInformationForm';

    /**
     * @var DoctorTitleRepositoryInterface
     */
    protected $doctorTitleRepository;

    /**
     * @var LanguageRepositoryInterface
     */
    protected $languageRepository;

    /**
     * BasicInformationRequest constructor.
     *
     * @param DoctorTitleRepositoryInterface $doctorTitleRepository
     * @param LanguageRepositoryInterface $languageRepository
     */
    public function __construct(
        DoctorTitleRepositoryInterface $doctorTitleRepository,
        LanguageRepositoryInterface $languageRepository
    ) {
        $this->doctorTitleRepository = $doctorTitleRepository;
        $this->languageRepository = $languageRepository;
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
        /** @var Collection $titleCollection */
        $titleCollection = $this->doctorTitleRepository->all();
        $listTitles = $titleCollection->pluck('id')->toArray();

        /** @var Collection $languageCollection */
        $languageCollection = $this->languageRepository->all();
        $listLanguages = $languageCollection->pluck('id')->toArray();

        $listGenders = Doctor::LIST_GENDERS;

        return [
            'title' => 'required|in:'.implode(',', $listTitles),
            'name' => 'required|min:3|max:255',
            'date_of_birth' => 'required|date_format:d/m/Y',
            'gender' => 'required|in:'.implode(',', array_keys($listGenders)),
            'languages' => 'required|min:1',
            'languages.*' => 'in:'.implode(',', $listLanguages),
        ];
    }

    public function messages()
    {
        return [];
    }
}
