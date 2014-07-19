<?php

namespace Ssa\SsaBundle\AsseticExtension;

use Assetic\Asset\AssetCollection;
use Assetic\Filter\FilterInterface;

/**
 * This Collection extends AssetCollection
 * It auto include ssa on asset javascript file
 *
 * @author thomas
 */
class SsaAssetCollection extends AssetCollection {
      
    /**
     * path to ssa javascript file
     * @var string 
     */
    private $ssaPath;
    
    public function __construct($assets = array(), $filters = array(), $sourceRoot = null, array $vars = array(), $ssaPath = null) {
        parent::__construct($assets, $filters, $sourceRoot, $vars);
        $this->ssaPath = $ssaPath;
    }
    
    public function load(FilterInterface $additionalFilter = null)
    {
        $mustLoadSsa = false;
        
        // loop through leaves and load each asset
        $parts = array();
        foreach ($this as $asset) {
            if (get_class($asset) == 'Ssa\SsaBundle\AsseticExtension\SsaAsset') {
                $mustLoadSsa = true;
                $asset->dontLoadSsa();
            }
            $asset->load($additionalFilter);
            $parts[] = $asset->getContent();
        }

        $this->content = $mustLoadSsa ? $this->loadSsa() : '';
        $this->content .= implode("\n", $parts); 
    }

    public function dump(FilterInterface $additionalFilter = null)
    {
        $mustLoadSsa = false;
        // loop through leaves and dump each asset
        $parts = array();
        foreach ($this as $asset) {
            if (get_class($asset) == 'Ssa\SsaBundle\AsseticExtension\SsaAsset') {
                $mustLoadSsa = true;
               $asset->dontLoadSsa();
            }
            $parts[] = $asset->dump($additionalFilter);
        }

        $content = $mustLoadSsa ? $this->loadSsa() : '';
        $content .= implode("\n", $parts); 
        return $content;
    }
    
    public function loadSsa() {
        $content = '';
        if ($this->ssaPath) {
            $content .= 'if (ssa == undefined) {';
            $content .= file_get_contents($this->ssaPath);
            $content .= '}'."\n";
        }
        return $content;
    }
}
