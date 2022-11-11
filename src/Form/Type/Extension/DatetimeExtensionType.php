<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace Optime\TimeZone\Bundle\Form\Type\Extension;

use Optime\TimeZone\Bundle\Entity\TimeZone;
use Optime\TimeZone\Bundle\TimeZoneAwareInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Manuel Aguirre
 */
class DatetimeExtensionType extends AbstractTypeExtension
{

    public static function getExtendedTypes(): iterable
    {
        return [DateTimeType::class];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('timezone', null);
        $resolver->setDefault('timezone_help', false);
        $resolver->setAllowedTypes('timezone_help', 'bool');
        $resolver->setAllowedTypes('timezone', [
            TimeZoneAwareInterface::class,
            TimeZone::class,
            'null',
        ]);


        $resolver->setDefault('view_timezone', function (Options $options) {
            return $this->getTimeZone($options)?->getName();
        });

        $resolver->setDefault('help', function (Options $options) {
            if (!$options['timezone_help']) {
                return null;
            }

            return $this->getTimeZone($options)?->getDescription();
        });
    }

    private function getTimeZone(Options $options): ?TimeZone
    {
        $timezone = $options['timezone'];

        if (!$timezone) {
            return null;
        }

        if ($timezone instanceof TimeZoneAwareInterface) {
            $timezone = $timezone->getTimeZone();
        }

        return $timezone;
    }
}