<?php

namespace Elendev\AppManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

class ConsoleController extends Controller
{
    
    /**
     * @Route("/console/exec/{app}/{appVersion}", name="console_exec")
     */
    public function execAction(Request $request, $app, $appVersion)
    {
        /* @var $archive \Elendev\AppManagerBundle\AppManager\AppArchive */
        $version = $this->get("elendev.app_manager.apps_manager")->getApp($app)->getVersion($appVersion);
        
        /* @var $console \Elendev\AppManagerBundle\AppManager\Console */
        $console = $this->get("elendev.app_manager.console_factory")->getConsole($version);
        
        //$command = $request->query->get("command");
        
        $cmd = new \Elendev\AppManagerBundle\AppManager\Console\Command("list", array(), array("--raw" => null));
        
        $console->exec($cmd);
        
        $this->get('session')->setFlash(
            'notice',
            'Did something go wrong ? Dont know ^^'
        );
        
        return $this->redirect($this->generateUrl("app_index", array('app' => $app)));
    }
    
    
    /**
     * @Route("/console/deploy/{app}/{appVersion}", name="console_deploy")
     */
    public function buildAction(Request $request, $app, $appVersion)
    {
        /* @var $version \Elendev\AppManagerBundle\AppManager\AppVersion */
        $version = $this->get("elendev.app_manager.apps_manager")->getApp($app)->getVersion($appVersion);
        
        /* @var $console \Elendev\AppManagerBundle\AppManager\Console\Console */
        $console = $this->get("elendev.app_manager.console_factory")->getConsole($version);
        
        $commandFactory = $version->getCommandFactory();
        
        
        foreach($version->getEnvironments() as $env){
            if($env->getName() != 'dev' && $env->getName() != 'test'){
                
                $clearCache = $commandFactory->createCommand("cache:clear", null, array('--env' => $env->getName()));
                $warmupCache = $commandFactory->createCommand("cache:warmup", null, array('--env' => $env->getName()));
                
                $assetic = $commandFactory->createCommand("assetic:dump", null, array('--env' => $env->getName()));
                $assets = $commandFactory->createCommand("assets:install", null, array('--env' => $env->getName()));
                
                $console->exec($clearCache);
                $console->exec($warmupCache);
                $console->exec($assetic);
                $console->exec($assets);
                
            }
        }
        
        
        
        $this->get('session')->setFlash(
            'notice',
            'Did something go wrong ? Dont know ^^'
        );
        
        return $this->redirect($this->generateUrl("app_index", array('app' => $app)));
    }
}
