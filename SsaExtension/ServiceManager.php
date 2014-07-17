<?php

namespace Ssa\SsaBundle\SsaExtension;

use ssa\ServiceNotRegistredException;
use ssa\ServiceMetadata;
use ssa\Configuration;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ssa\ssaBundle\ssaExtension\SymfonyServiceMetadata;

class ServiceManager {
    
    /**
     * service list, this list is provided by the configuration (config.yml)
     * @var array
     */
    private $services;
    
    private $container;
    
    /**
     * create the service
     * 
     * @param array $services
     * @param array $configuration
     * @param ContainerInterface $container
     */
    public function __construct($services, $configuration, ContainerInterface $container) {
        $this->services = $services;
        $this->container = $container;
        
        if ($configuration) {
            Configuration::getInstance()->configure($configuration);
        }
    }
    
    
    /**
     * 
     * @param string $serviceName the service name
     */
    public function getServiceMetadata($serviceName) {
        if (!isset($this->services[$serviceName])) {
            throw new ServiceNotRegistredException($serviceName);
        }
       
        if (isset($this->services[$serviceName]['class'])) {
            return new ServiceMetadata(
                $serviceName,
                $this->services[$serviceName]['class'],
                isset($this->services[$serviceName]['methods']) ? $this->services[$serviceName]['methods'] : array()
            );
        } else {
            return new SymfonyServiceMetadata(
                $serviceName,
                $this->container,
                $this->services[$serviceName]['service'],
                isset($this->services[$serviceName]['methods']) ? $this->services[$serviceName]['methods'] : array()
            );
        }
    }
}