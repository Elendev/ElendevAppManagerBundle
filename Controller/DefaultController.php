<?php

namespace Elendev\AppManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{

    /**
     * @Route("/{app}", name="app_index",  defaults={"app" = null})
     * @Template()
     */
    public function indexAction($app = null)
    {
        $apps = $this->get("elendev.app_manager.apps_manager")->getAppsName();
        
        if($app == null || strlen($app) == 0){
            $app = $apps[0];
        }
        
        if($app == null){
            throw $this->createNotFoundException("App $app not found");
        }
        
        return array("apps" => $apps, 
            "currentApp" => $this->get("elendev.app_manager.apps_manager")->getApp($app));
    }
}
