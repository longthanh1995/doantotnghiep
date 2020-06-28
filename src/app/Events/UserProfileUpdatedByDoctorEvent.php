<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\ManaUser;
use App\Models\Patient;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserProfileUpdatedByDoctorEvent extends Event
{
    use SerializesModels;

    /**
     * @var ManaUser
     */
    protected $user;

    /**
     * UserProfileUpdatedByDoctorEvent constructor.
     * @param Doctor $doctor
     * @param ManaUser $user
     */
    public function __construct(Doctor $doctor, ManaUser $user, Patient $patient)
    {
        $this->doctor = $doctor;
        $this->user = $user;
        $this->patient = $patient;
    }

    /**
     * @return Doctor
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * @return ManaUser
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
