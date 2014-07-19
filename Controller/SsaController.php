<?php

namespace Ssa\SsaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use ssa\runner\ServiceRunner;

/**
 * controller for run php services
 */
class SsaController extends Controller
{
    public function runAction($action, Request $request) {
        $serviceManager = $this->get('ssa.serviceManager');
        
        // explode the action and method action.method
        list($service, $method) = explode('.', $action);
        
        $serviceRunner = new ServiceRunner(
            $serviceManager->getServiceMetadata($service),
            $this->get('ssa.parameterResolver')
        );
        
        $response =  new Response('Content', 200, array('content-type' => 'text/html'));
        $parameters = $request->request->all();
        $response->setContent($serviceRunner->runAction($method, $parameters));
        return $response;        
    }
    
    public function testAction() {
        return $this->render('ssaBundle:Ssa:run.html.twig');
    }
}
