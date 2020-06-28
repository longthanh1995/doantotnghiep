<?php

namespace App\Repositories\Eloquent;

use App\Models\CMEOrganizer;
use App\Repositories\CMEOrganizerRepositoryInterface;

/**
 * Class CMEOrganizerRepository
 * @package App\Repositories\Eloquent
 */
class CMEOrganizerRepository extends AuthenticatableRepository implements CMEOrganizerRepositoryInterface
{
    /**
     * @return \App\Models\AuthenticatableBase|\App\Models\Base|CMEOrganizer|\Illuminate\Database\Eloquent\Model
     */
    public function getBlankModel()
    {
        return new CMEOrganizer();
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
