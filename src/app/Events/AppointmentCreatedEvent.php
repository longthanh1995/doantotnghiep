<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Appointment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AppointmentCreatedEvent extends Event
{
    use SerializesModels;

    /**
     * @var Appointment
     */
    protected $appointment;

    /**
     * AppointmentCreatedEvent constructor.
     * @param Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * @return Appointment
     */
    public function getAppointment()
    {
        return $this->appointment;
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
