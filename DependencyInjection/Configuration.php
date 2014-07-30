<?php

namespace Ssa\SsaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     *
     * @var ContainerBuilder
     */
    private $container;
    
    public function __construct(ContainerBuilder $container) {
        $this->container = $container;
    }
    
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
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('debug')
                            ->defaultValue($this->container->getParameter('kernel.debug'))
                            ->end()
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
                    ->addDefaultsIfNotSet()
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
