<?php

namespace Ssa\SsaBundle\SsaExtension;

use ssa\ServiceMetadata;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of SymfonyServiceMetadata
 *
 * @author thomas
 */
class SymfonyServiceMetadata extends ServiceMetadata {
    /**
     *
     * @var ContainerInterface 
     */
    private $container;
    
    /**
     * the symfony service name
     * @var string
     */
    private $symfonyServiceName;
    
    /**
     * instance of the symfony service
     * 
     * @var object 
     */
    private $serviceInstance;
    
    public function __construct(
        $serviceName,
        ContainerInterface $container,
        $symfonyServiceName,
        array $supportedMethod = array()
    ) {
        $this->symfonyServiceName = $symfonyServiceName;
        $this->container = $container;
        
        $className = \get_class($this->getInstance());
        
        parent::__construct($serviceName, $className, $supportedMethod);
    }
    
    public function getInstance() {
        if ($this->serviceInstance == null) {
            $this->serviceInstance = $this->container->get($this->symfonyServiceName);
        }
        return $this->serviceInstance;
    }
    

}
