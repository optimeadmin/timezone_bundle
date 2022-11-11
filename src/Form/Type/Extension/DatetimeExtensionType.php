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
        $resolver->setDefault('apply_timezone', null);
        $resolver->setAllowedTypes('apply_timezone', [
            TimeZoneAwareInterface::class,
            TimeZone::class,
        ]);

        $resolver->setDefault('view_timezone', function (Options $options) {
            $timezone = $options['apply_timezone'];

            if (!$timezone) {
                return null;
            }

            if ($timezone instanceof TimeZoneAwareInterface) {
                $timezone = $timezone->getTimeZone();
            }

            return $timezone->getName();
        });
    }
}