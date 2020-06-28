<?php

namespace App\Services;

interface AppointmentServiceInterface extends BaseServiceInterface
{
    public function sendAppointmentEvent(int $appointmentID, string $event);
}
