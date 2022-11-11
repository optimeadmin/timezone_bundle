<?php

declare(strict_types=1);

namespace Optime\TimeZone\Bundle\DependencyInjection;

use Optime\Acl\Bundle\Security\User\DefaultRolesProvider;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('optime_timzone');
        $rootNode    = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
