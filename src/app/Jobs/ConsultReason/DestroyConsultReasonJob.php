<?php namespace App\Jobs\ConsultReason;

use App\Jobs\Job;
use App\Models\ConsultReason;
use App\Repositories\ConsultReasonRepositoryInterface;

/**
 * Class DestroyConsultReasonJob
 * @package App\Jobs\ConsultReason
 */
class DestroyConsultReasonJob extends Job
{
    /**
     * @var ConsultReason
     */
    protected $consultReason;

    /**
     * DestroyConsultReasonJob constructor.
     * @param ConsultReason $consultReason
     */
    public function __construct(
        ConsultReason $consultReason
    )
    {
        $this->consultReason = $consultReason;
    }

    /**
     * @param ConsultReasonRepositoryInterface $consultReasonRepository
     * @return ConsultReason
     */
    public function handle(ConsultReasonRepositoryInterface $consultReasonRepository)
    {
        $consultReasonRepository->delete($this->consultReason);

        return $this->consultReason;
    }
}