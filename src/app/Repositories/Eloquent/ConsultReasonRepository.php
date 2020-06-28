<?php

namespace App\Repositories\Eloquent;

use App\Models\ConsultReason;
use App\Repositories\ConsultReasonRepositoryInterface;

class ConsultReasonRepository extends SingleKeyModelRepository implements ConsultReasonRepositoryInterface
{
    public function getBlankModel()
    {
        return new ConsultReason();
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
