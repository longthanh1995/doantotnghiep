<?php namespace App\Repositories\Eloquent;

use App\Models\Activity;
use App\Repositories\ActivityRepositoryInterface;

class ActivityRepository extends SingleKeyModelRepository implements ActivityRepositoryInterface
{
    /**
     * @return Activity
     */
    public function getBlankModel()
    {
        return new Activity();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}