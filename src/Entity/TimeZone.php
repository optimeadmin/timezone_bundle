<?php

namespace Optime\Timezone\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Optime\Timezone\Bundle\Repository\TimeZoneRepository;

#[ORM\Table(name: "optime_bundle_time_zone")]
#[ORM\Entity(repositoryClass: TimeZoneRepository::class)]
#[ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")]
class TimeZone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $description;

    #[ORM\Column]
    private string $relativeToGmt;

    #[ORM\Column]
    private string $gmtNumber;

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
}