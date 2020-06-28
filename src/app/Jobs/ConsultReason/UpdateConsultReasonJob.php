<?php namespace App\Jobs\ConsultReason;

use App\Jobs\Job;
use App\Models\ConsultReason;
use App\Repositories\ConsultReasonRepositoryInterface;

/**
 * Class UpdateConsultReasonJob
 * @package App\Jobs\ConsultReason
 */
class UpdateConsultReasonJob extends Job
{
    /**
     * @var ConsultReason
     */
    protected $consultReason;

    /**
     * @var array
     */
    protected $data;

    /**
     * UpdateConsultReasonJob constructor.
     * @param ConsultReason $consultReason
     * @param array $data
     */
    public function __construct(
        ConsultReason $consultReason,
        array $data
    )
    {
        $this->consultReason = $consultReason;
        $this->data = $this->buildData($data);
    }

    /**
     * @param $data
     * @return array
     */
    protected function buildData($data)
    {
        return array_only($data, [
            'reason',
            'appointment_type_id',
            'parent_id'
        ]);
    }

    /**
     * @param ConsultReasonRepositoryInterface $consultReasonRepository
     * @return \App\Models\Base
     */
    public function handle(ConsultReasonRepositoryInterface $consultReasonRepository)
    {
        $consultReason = $consultReasonRepository->update($this->consultReason, $this->data);

        return $consultReason;
    }
}