<?php

namespace App\Helpers;

interface DateTimeHelperInterface
{
    public function getTimeOptions($fromHour = 0, $toHour = 24, $dividerMinutes = 15);

    public function getTimeOptionsForDoctor();

    public function convertDateTimeToMinuteSecond(\DateTime $dateTime);

    /**
     * @param \DateTime $dateTime
     * @param $timezoneStr
     * @return \DateTime
     */
    public function setTimeZoneByStr(\DateTime $dateTime, $timezoneStr);

    /**
     * @param $index
     * @return mixed
     */
    public function getDayNameFromInteger($index);
}
