<?php

namespace Ssa\SsaBundle\SsaExtension;

use ssa\converter\UrlFactory;
use Symfony\Component\Routing\RouterInterface;

/**
 * service for create route based on route parameter
 * the service name is pass to the route by the "action" name
 * example : /run/my/service/{action}
 * 
 * @author thomas
 */
class SymfonyRouteUrlFactory implements UrlFactory {
    private $router;
    
    private $route;
    
    /**
     * the symfony ssa router
     * create a route with a symfony route
     * 
     * @param RouterInterface $router
     * @param string the route name
     */
    public function __construct(RouterInterface $router, $route) {
        $this->router = $router;
        $this->route = $route;
    }

    /**
     * {@inherits}
     */
    public function constructUrl($action) {
        return $this->router->generate(
            $this->route,
            array(
                'action' => $action
            )
        );
    }

}
