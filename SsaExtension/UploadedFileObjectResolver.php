<?php

namespace Ssa\SsaBundle\SsaExtension;

use ssa\runner\resolver\ObjectResolverCOR;

/**
 * find parameter into database for doctrine entity
 *
 * @author thomas
 */
class UploadedFileObjectResolver extends ObjectResolverCOR {
    
      
    protected function canResolve(\ReflectionClass $class) {
        return $class->getName() == 'Symfony\Component\HttpFoundation\File\UploadedFile';
    }

    protected function resolve(\ReflectionClass $class, $parameters, array &$commentType) {
        if (is_array($parameters)) {
            return $parameters[0];
        }
        return $parameters;
    }

}
