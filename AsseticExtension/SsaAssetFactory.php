<?php

/**
 * this is a specific factory for add ssa assetic support
 * this factory can crate SsaAssetic and SsaAsseticCollection
 */
namespace Ssa\SsaBundle\AsseticExtension;

use Symfony\Bundle\AsseticBundle\Factory\AssetFactory;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SsaAssetFactory extends AssetFactory
{
    private $container;
    private $kernel;
    private $root;
    private $ssaJsFile;
    private $converterClass;
    
    /**
     * Constructor.
     *
     * @param KernelInterface       $kernel       The kernel is used to parse bundle notation
     * @param ContainerInterface    $container    The container is used to load the managers lazily, thus avoiding a circular dependency
     * @param ParameterBagInterface $parameterBag The container parameter bag
     * @param string                $baseDir      The base directory for relative inputs
     * @param Boolean               $debug        The current debug mode
     */
    public function __construct(KernelInterface $kernel, ContainerInterface $container, ParameterBagInterface $parameterBag, $baseDir, $debug = false)
    {        
        $this->kernel = $kernel;
        $this->container = $container;
        $this->root = $baseDir;
        $configuration = $container->getParameter('ssa.configuration');
        $this->converterClass = $container->getParameter('ssa.converter.class');
        $this->ssaJsFile = $configuration['ssaJsFile'];
        
        parent::__construct($kernel, $container, $parameterBag, $baseDir, $debug);
    }

    /**
     * Parses an input string string into an asset.
     *
     * The input string can be one of the following:
     *
     *  * A reference:     If the string starts with an "at" sign it will be interpreted as a reference to an asset in the asset manager
     *  * An absolute URL: If the string contains "://" or starts with "//" it will be interpreted as an HTTP asset
     *  * A glob:          If the string contains a "*" it will be interpreted as a glob
     *  * A path:          Otherwise the string is interpreted as a filesystem path
     *
     * Both globs and paths will be absolutized using the current root directory.
     *
     * @param string $input   An input string
     * @param array  $options An array of options
     *
     * @return AssetInterface An asset
     */
    protected function parseInput($input, array $options = array())
    {
        if (0 === strpos($input, 'ssa:')) {
            // create a ssaAsset
            $serviceManager = $this->container->get('ssa.serviceManager');
            $urlFactory = $this->container->get('ssa.urlFactory');
            $serviceName = substr($input, 4);
            
            return new SsaAsset(
                $serviceManager->getServiceMetadata($serviceName),
                $urlFactory,
                $this->root . DIRECTORY_SEPARATOR . $this->ssaJsFile,
                $this->converterClass
            );
        }
        
        return parent::parseInput($input, $options);
    }
    
    protected function createAssetCollection(array $assets = array(), array $options = array())
    {
        return new SsaAssetCollection(
            $assets,
            array(),
            null,
            isset($options['vars']) ? $options['vars'] : array(),
            $this->root . DIRECTORY_SEPARATOR . $this->ssaJsFile
        );
    }
}
