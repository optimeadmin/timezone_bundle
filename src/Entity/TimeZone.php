<?php

namespace Optime\TimeZone\Bundle\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Optime\TimeZone\Bundle\Repository\TimeZoneRepository;

#[ORM\Table(name: "optime_bundle_time_zone")]
#[ORM\Entity(repositoryClass: TimeZoneRepository::class)]
#[ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")]
class TimeZone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(length: 110)]
    private string $name;

    #[ORM\Column(length: 110)]
    private string $description;

    #[ORM\Column(length: 10)]
    private string $relativeToGmt;

    #[ORM\Column(length: 6)]
    private string $gmtNumber;

    public function __construct(string $name, string $description, string $relativeToGmt, string $gmtNumber)
    {
        $this->name = $name;
        $this->description = $description;
        $this->relativeToGmt = $relativeToGmt;
        $this->gmtNumber = $gmtNumber;
    }


    public function __toString()
    {
        return $this->getDescription();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRelativeToGmt(): string
    {
        return $this->relativeToGmt;
    }

    public function getGmtNumber(): string
    {
        return $this->gmtNumber;
    }

    public function toDateTimeZone(): \DateTimeZone
    {
        return new \DateTimeZone($this->getName());
    }

    public function convert(DateTimeInterface $dateTime): DateTimeInterface
    {
        $timeZone = $this->toDateTimeZone();

        if ($dateTime->getTimezone() === $timeZone) {
            return $dateTime;
        }

        return DateTimeImmutable::createFromInterface($dateTime)->setTimezone($timeZone);
    }
}