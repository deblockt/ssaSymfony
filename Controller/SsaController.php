<?php

namespace Ssa\SsaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use ssa\runner\ServiceRunner;

class SsaController extends Controller
{
    public function runAction($action, Request $request) {
        $serviceManager = $this->get('ssa.serviceManager');
        
        // explode the action and method action.method
        list($service, $method) = explode('.', $action);
        
        $serviceRunner = new ServiceRunner($serviceManager->getServiceMetadata($service));
        $response =  new Response('Content', 200, array('content-type' => 'text/html'));
        $parameters = $request->request->all();
        $response->setContent($serviceRunner->runAction($method, $parameters));
        return $response;        
    }
    
    public function testAction() {
        return $this->render('ssaBundle:Ssa:run.html.twig');
    }
}
