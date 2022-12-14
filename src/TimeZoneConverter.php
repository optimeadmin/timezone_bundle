<?php
/**
 * @author Manuel Aguirre
 */

namespace Optime\TimeZone\Bundle;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use function date_default_timezone_get;

/**
 * @author Manuel Aguirre
 */
class TimeZoneConverter
{
    public function convert(DateTimeInterface $dateTime, TimeZoneAwareInterface $timeZoneAware): DateTimeInterface
    {
        $timeZone = $timeZoneAware->getTimeZone()?->toDateTimeZone();

        if (null === $timeZone) {
            return $this->toImmutable($dateTime);
        }

        return $this->doConvert($dateTime, $timeZone);
    }

    public function toSystem(DateTimeInterface $dateTime): DateTimeInterface
    {
        return $this->doConvert($dateTime, $this->getSystemDateTimeZone());
    }

    public function getSystemDateTimeZone(): DateTimeZone
    {
        return new \DateTimeZone(date_default_timezone_get());
    }

    private function doConvert(DateTimeInterface $dateTime, DateTimeZone $timeZone): DateTimeInterface
    {
        $dateTime = $this->toImmutable($dateTime);

        return $dateTime->setTimezone($timeZone);
    }

    private function toImmutable(DateTimeInterface $dateTime): DateTimeImmutable
    {
        return DateTimeImmutable::createFromInterface($dateTime);
    }
}