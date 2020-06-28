<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ManaUserRepositoryInterface;
use App\Models\ManaUser;

class ManaUserRepository extends AuthenticatableRepository implements ManaUserRepositoryInterface
{
    public function getBlankModel()
    {
        return new ManaUser();
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
