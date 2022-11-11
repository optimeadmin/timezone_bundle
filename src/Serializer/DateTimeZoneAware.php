<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace Optime\TimeZone\Bundle\Serializer;

use DateTimeInterface;
use JsonSerializable;
use Optime\TimeZone\Bundle\Entity\TimeZone;
use Optime\TimeZone\Bundle\TimeZoneAwareInterface;
use Stringable;

/**
 * @author Manuel Aguirre
 */
class DateTimeZoneAware implements Stringable, JsonSerializable
{
    private ?TimeZoneAwareInterface $owner = null;

    public function __construct(
        public readonly ?DateTimeInterface $dateTime,
        public readonly ?string $format = DateTimeInterface::W3C,
        private readonly string $default = '',
    ) {
    }

    public static function from(
        TimeZoneAwareInterface $owner,
        ?DateTimeInterface $dateTime,
        ?string $format = DateTimeInterface::W3C,
        string $default = '',
    ): self {
        $object = new self($dateTime, $format, $default);
        $object->owner = $owner;

        return $object;
    }

    public function __toString(): string
    {
        if (!$this->dateTime) {
            return $this->default;
        }

        if ($this->owner) {
            $dateTime = $this->owner->getTimeZone()->convert($this->dateTime);
        } else {
            $dateTime = $this->dateTime;
        }

        return $dateTime->format($this->format);
    }

    public function jsonSerialize(): mixed
    {
        return $this->__toString();
    }

    public function getOwner(): ?TimeZoneAwareInterface
    {
        return $this->owner;
    }

    public function convert(TimeZone $timeZone): self
    {
        if (!$this->dateTime) {
            return clone $this;
        }

        return new self($timeZone->convert($this->dateTime), $this->format, $this->default);
    }
}