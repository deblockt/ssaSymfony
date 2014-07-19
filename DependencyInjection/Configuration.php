<?php

namespace Ssa\SsaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ssa');
        $rootNode
            ->children()
                ->arrayNode('services')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('service')->end()
                            ->scalarNode('class')->end()
                            ->arrayNode('methods')
                                ->prototype('scalar')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('configuration')
                    ->children()
                        ->booleanNode('debug')->defaultValue('%kernel.debug%')->end()
                        ->enumNode('cacheMode')
                            ->values(array('file', 'apc', 'memcache'))
                        ->end()
                        ->scalarNode('cacheDirectory')->end()
                        ->scalarNode('memcacheHost')->end()
                        ->scalarNode('memcachePort')->end()
                        ->scalarNode('ssaJsFile')->defaultValue('../vendor/ssa/core/javascript/ssa.js')->end()
                    ->end()
                ->end()
                ->arrayNode('parameterResolver')
                    ->children()
                        ->arrayNode('primitive')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                        ->arrayNode('object')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
