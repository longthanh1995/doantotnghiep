<?php

namespace App\Repositories\Eloquent;

use App\Repositories\LanguageRepositoryInterface;
use App\Models\Language;

class LanguageRepository extends SingleKeyModelRepository implements LanguageRepositoryInterface
{
    public function getBlankModel()
    {
        return new Language();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
