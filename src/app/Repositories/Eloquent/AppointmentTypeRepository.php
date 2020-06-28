<?php namespace App\Repositories\Eloquent;

use \App\Repositories\AppointmentTypeRepositoryInterface;
use \App\Models\AppointmentType;

class AppointmentTypeRepository extends SingleKeyModelRepository implements AppointmentTypeRepositoryInterface
{

    public function getBlankModel()
    {
        return new AppointmentType();
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

    public function findAllOrderByName()
    {
        return $this->getBlankModel()->orderBy('name', 'asc')->get();
    }

    public function findActiveOrderByName()
    {
        return $this->getBlankModel()->where('is_active', 1)->orderBy('name', 'asc')->get();
    }

}
