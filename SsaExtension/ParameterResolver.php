<?php

namespace Ssa\SsaBundle\SsaExtension;

use ssa\runner\resolver\impl\DefaultParameterResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ssa\runner\resolver\impl\DefaultPrimitiveResolver;
use ssa\runner\resolver\impl\ArrayPrimitiveResolver;
use ssa\runner\resolver\impl\DefaultObjectResolver;
use ssa\runner\resolver\impl\DateTimeObjectResolver;

/**
 * Description of ParameterResolver
 *
 * @author thomas
 */
class ParameterResolver extends DefaultParameterResolver {
    
    /**
     * 
     * @param array $configuration the ssa configuration
     */
    public function __construct($configuration, ContainerInterface $container) {
        $this->addPrimitiveResolver(new DefaultPrimitiveResolver());
        $this->addPrimitiveResolver(new ArrayPrimitiveResolver());
        $this->addObjectResolver(new DefaultObjectResolver());
        $this->addObjectResolver(new DateTimeObjectResolver());
        $this->addObjectResolver($container->get('ssa.resolver.doctrineResolver'));
        $this->addObjectResolver(new UploadedFileObjectResolver());
        
        
        // add own PrimitiveResolver
        if (isset($configuration['primitive'])) {
            foreach ($configuration['primitive'] as $resolver) {
                if (class_exists($resolver)) {
                    $this->addPrimitiveResolver(new $resolver());
                } else {
                    $this->addPrimitiveResolver($container->get($resolver));
                }
            }
        }
        
        // add own object Resolver
        if (isset($configuration['object'])) {
            foreach ($configuration['object'] as $resolver) {
                if (class_exists($resolver)) {
                    $this->addObjectResolver(new $resolver());
                } else {
                    $this->addObjectResolver($container->get($resolver));
                }
            }
        }
    }
}
