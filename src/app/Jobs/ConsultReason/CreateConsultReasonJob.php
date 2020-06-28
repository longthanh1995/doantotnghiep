<?php namespace App\Jobs\ConsultReason;

use App\Jobs\Job;
use App\Repositories\ConsultReasonRepositoryInterface;

/**
 * Class CreateConsultReasonJob
 * @package App\Jobs\ConsultReason
 */
class CreateConsultReasonJob extends Job
{
    /**
     * @var array
     */
    protected $data;

    /**
     * CreateConsultReasonJob constructor.
     * @param array $data
     */
    public function __construct(
        array $data
    )
    {
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
        $consultReason = $consultReasonRepository->create($this->data);

        return $consultReason;
    }
}