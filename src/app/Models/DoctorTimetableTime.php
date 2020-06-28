<?php

namespace App\Models;

use Carbon\Carbon;

class DoctorTimetableTime
{
    protected $start;

    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;

        $this->end = $end;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param $date
     * @param $time
     *
     * @return Carbon
     */
    public static function toDate($date, $time, $timezone)
    {
        $carbon = new Carbon(null, $timezone);

        list($day, $month, $year) = explode('/', $date);

        $hour = $time / 60;
        $minute = $time % 60;

        $carbon->setDateTime($year, $month, $day, $hour, $minute);
        $carbon->setTimezone(config('app.timezone'));

        return $carbon;
    }
}
