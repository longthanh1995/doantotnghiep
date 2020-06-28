<?php

namespace App\Helpers\Production;

use App\Helpers\DateTimeHelperInterface;
use Carbon\Carbon;

class DateTimeHelper implements DateTimeHelperInterface
{
    private $dayNames = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];

    public function getTimeOptions($fromHour = 0, $toHour = 24, $dividerMinutes = 5)
    {
        $options = [];

        for ($i = $fromHour; $i < $toHour; $i++) {
            for ($k = 0; $k < 60; $k = $k + $dividerMinutes) {
                $iPresent = $i < 10 ? '0'.$i : $i;
                $kPresent = $k < 10 ? '0'.$k : $k;

                $options[$i * 60 + $k] = $iPresent.':'.$kPresent;
            }
        }

        return $options;
    }

    public function getTimeOptionsForDoctor()
    {
        return $this->getTimeOptions(0, 24);
    }

    public function convertDateTimeToMinuteSecond(\DateTime $dateTime)
    {
        $minute = (int) $dateTime->format('H');
        $second = (int) $dateTime->format('i');

        return $minute * 60 + $second;
    }

    /**
     * @inheritdoc
     */
    public function setTimeZoneByStr(\DateTime $dateTime, $timezoneStr)
    {
        return $dateTime->setTimezone(new \DateTimeZone($timezoneStr));
    }

    /**
     * @param $index
     * @return mixed
     */
    public function getDayNameFromInteger($index)
    {
        //make sure the index is within 1 & 7
        $index = $index % 7;

        if($index == 0){
            $index = 7;
        }

        return $this->dayNames[$index - 1];
    }
}
