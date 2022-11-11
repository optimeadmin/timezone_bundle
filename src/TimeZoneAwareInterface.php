<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace Optime\TimeZone\Bundle;

use Optime\TimeZone\Bundle\Entity\TimeZone;

/**
 * @author Manuel Aguirre
 */
interface TimeZoneAwareInterface
{
    public function getTimeZone(): ?TimeZone;
}