<?php

namespace Ssa\SsaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SsaExtension extends Extension
{
 
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {            
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $configuration = new Configuration($container);
        $config = $this->processConfiguration($configuration, $configs);
                
        $container->setParameter('ssa.services', $config['services']);
        $container->setParameter('ssa.configuration', $config['configuration']);         
        $container->setParameter('ssa.parameterResolver', $config['parameterResolver']); 
    }
}
