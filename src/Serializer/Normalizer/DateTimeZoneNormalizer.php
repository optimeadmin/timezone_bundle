<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace Optime\TimeZone\Bundle\Serializer\Normalizer;

use DateTimeInterface;
use Optime\TimeZone\Bundle\Entity\TimeZone;
use Optime\TimeZone\Bundle\Serializer\DateTimeZoneAware;
use Optime\TimeZone\Bundle\TimeZoneAwareInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

/**
 * @author Manuel Aguirre
 */
#[AutoconfigureTag("serializer.normalizer", ['priority' => 10])]
class DateTimeZoneNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    final public const TIMEZONE = 'timezone';
    final public const USER_TIMEZONE = 'user_timezone';

    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        if (!isset($context[self::TIMEZONE]) && !isset($context[self::USER_TIMEZONE])) {
            return false;
        }

        return $data instanceof DateTimeInterface || $data instanceof DateTimeZoneAware;
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $timeZone = $this->extractTimezone($context);

        if ($timeZone instanceof TimeZone) {
            if ($object instanceof DateTimeZoneAware) {
                return (string)$object->convert($timeZone);
            }

            $object = $timeZone->convert($object);
        }

        unset($context[self::USER_TIMEZONE]);
        unset($context[self::TIMEZONE]);
        return $this->normalizer->normalize($object, $format, $context);
    }

    private function extractTimezone(array $context): ?TimeZone
    {
        if ($context[self::USER_TIMEZONE] ?? false) {
            $user = $this->security->getUser();

            if ($user instanceof TimeZoneAwareInterface) {
                return $user->getTimeZone();
            }
        } else {
            $timeZone = $context[self::TIMEZONE] ?? null;

            if ($timeZone instanceof TimeZoneAwareInterface) {
                $timeZone = $timeZone->getTimeZone();
            }

            if (!$timeZone instanceof TimeZone) {
                throw new LogicException(
                    "La opción timezone debe ser de tipo " . TimeZone::class .
                    " o " . TimeZoneAwareInterface::class
                );
            }

            return $timeZone;
        }

        return null;
    }
}