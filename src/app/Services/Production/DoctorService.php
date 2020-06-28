<?php

namespace App\Services\Production;

use App\Repositories\DoctorRepositoryInterface;
use App\Services\DoctorServiceInterface;

class DoctorService extends AuthenticatableService implements DoctorServiceInterface
{
    public function __construct(DoctorRepositoryInterface $doctorRepository)
    {
        parent::__construct($doctorRepository);
    }

    protected function getGuardName()
    {
        return 'doctors';
    }
}
