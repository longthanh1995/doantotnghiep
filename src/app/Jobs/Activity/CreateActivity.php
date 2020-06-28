<?php namespace App\Jobs\Activity;

use App\Jobs\Job;
use App\Repositories\ActivityRepositoryInterface;

class CreateActivity extends Job
{
    public function __construct(
        $subjectType,
        $subjectId,
        $action,
        $objectType,
        $objectId,
        $description,
        $objectBefore = null,
        $objectAfter = null
    )
    {
        $this->subjectType = $subjectType;
        $this->subjectId = $subjectId;
        $this->action = $action;
        $this->objectType = $objectType;
        $this->objectId = $objectId;
        $this->description = $description;
        $this->objectBefore = $objectBefore;
        $this->objectAfter = $objectAfter;
    }

    public function handle(ActivityRepositoryInterface $activityRepository)
    {
        $activity = $activityRepository->create([
            'subject_type' => $this->subjectType,
            'subject_id' => $this->subjectId,
            'action' => $this->action,
            'object_type' => $this->objectType,
            'object_id' => $this->objectId,
            'description' => $this->description,
            'object_before' => $this->objectBefore,
            'object_after' => $this->objectAfter
        ]);

        /*
         * Dispatch event
         */
        //@TODO: Add an event here

        return $activity;
    }
}