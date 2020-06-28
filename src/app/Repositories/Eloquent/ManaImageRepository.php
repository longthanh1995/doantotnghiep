<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ManaImageRepositoryInterface;
use App\Models\ManaImage;

class ManaImageRepository extends SingleKeyModelRepository implements ManaImageRepositoryInterface
{
    public function getBlankModel()
    {
        return new ManaImage();
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
