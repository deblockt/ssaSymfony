<?php

namespace Ssa\SsaBundle\AsseticExtension;

use Assetic\Asset\BaseAsset;
use ssa\ServiceMetadata;
use ssa\converter\UrlFactory;

use ssa\Configuration;

/**
 * asset for load ssa asset
 * ssa asset avec input frmat like this : "ssa:serviceName"
 *
 * @author thomas
 */
class SsaAsset extends BaseAsset {
    
    private $serviceMetadata;
    
    private $urlFactory;
    
    private $ssaJavascriptFile;
    
    private $mustLoadSsa;
    
    private $converterClass;
    
    /**
     * Constructor.
     *
     * @param ssa\ServiceMetadata $source     An absolute path
     * @param ssa\UrlFactory $urlFactory the url factory
     * @param array  $filters    An array of filters
     * @param string $sourceRoot The source asset root directory
     * @param string $converterClass
     * @param string $sourcePath The source asset path
     * @param array  $vars
     *
     * @throws \InvalidArgumentException If the supplied root doesn't match the source when guessing the path
     */
    public function __construct(
        ServiceMetadata $serviceMetadata,
        UrlFactory $urlFactory,
        $ssaJavascriptFile,
        $converterClass,
        $filters = array(),
        array $vars = array()
    )
    {
        $this->mustLoadSsa = true;
        $this->ssaJavascriptFile = $ssaJavascriptFile;
        $this->serviceMetadata = $serviceMetadata;
        $this->urlFactory = $urlFactory;
        $this->converterClass = $converterClass;
        parent::__construct($filters, null, $this->serviceMetadata->getServiceName(), $vars);
    }

    public function dontLoadSsa() {
        $this->mustLoadSsa = false;
    }
    
    public function getLastModified() {
        return filemtime($this->serviceMetadata->getClass()->getFileName());
    }

    public function load(\Assetic\Filter\FilterInterface $additionalFilter = null) {
        $content = '';
        try {
            $converter = new $this->converterClass(
                $this->serviceMetadata,
                $this->urlFactory
            );
            
            if ($this->mustLoadSsa) {
                $content .= 'if (ssa == undefined) {';
                $content .= file_get_contents($this->ssaJavascriptFile);
                $content .= '}';
            }
            
            $this->mustLoadSsa = true;
            
            $content .= $converter->convert();  
        } catch (\Exception $ex) {
            $content = 'console.error("message : "+ '.json_encode($ex->getMessage()).');'."\n";
            if (Configuration::getInstance()->getDebug()) {
                $content .= 'console.error("code :  '.$ex->getCode().'");'."\n";
                $content .= 'console.error("file : "+'.json_encode($ex->getFile()).');'."\n";
                $content .= 'console.error("line : '.$ex->getLine().'");'."\n";
                $content .= 'console.error('.json_encode($ex->getTraceAsString()).');'."\n";
            }
        }
        
        $this->doLoad($content, $additionalFilter);
    }

}
