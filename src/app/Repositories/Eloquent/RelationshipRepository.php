<?php

namespace App\Repositories\Eloquent;

use App\Models\Relationship;
use App\Repositories\RelationshipRepositoryInterface;

class RelationshipRepository extends SingleKeyModelRepository implements RelationshipRepositoryInterface
{
    public function getBlankModel()
    {
        return new Relationship();
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
