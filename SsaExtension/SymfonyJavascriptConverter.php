<?php

namespace Ssa\SsaBundle\SsaExtension;

use ssa\converter\JavascriptConverter;

/**
 * Description of SymfonyJavascriptConverter
 *
 * @author thomas
 */
class SymfonyJavascriptConverter extends JavascriptConverter {
       
    /**
     * function return true if this type must use form data
     * 
     * @param array $types
     */
    public function mustUseFormData(array $types) {
        foreach ($types as $type) {
            if ($type == 'file' || $type == 'Symfony\Component\HttpFoundation\File\UploadedFile') {
                return true;
            }
        }
        
        return false;
    }
}
