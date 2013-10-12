<?php

namespace Elendev\AppManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;

class AppController extends Controller
{
    
    /**
     * @Route("/app/unzip/{app}/{zipFile}", name="app_unzip")
     */
    public function unzipAction($app, $zipFile)
    {
        /* @var $archive \Elendev\AppManagerBundle\AppManager\AppArchive */
        $archive = $this->get("elendev.app_manager.apps_manager")->getApp($app)->getArchive($zipFile);
        
        $zip = new \ZipArchive();
        
        if($zip->open($archive->getPath())){
            $zip->extractTo(dirname($archive->getPath()));
        
            if(file_exists(dirname($archive->getPath()) . "/__MACOSX")){
                $fs = new Filesystem();
                $fs->remove(dirname($archive->getPath()) . "/__MACOSX");
            }
            
            $this->get('session')->getFlashBag()->add(
                'notice',
                'The archive has been correctly unarchived'
            );
        }else{
            $this->get('session')->getFlashBag()->add(
                'error',
                'Oups, couldn\'t extract archive'
            );
        }
        
        return $this->redirect($this->generateUrl("app_index", array('app' => $app)));
    }
    
    /**
     * @Route("/app/removeArchive/{app}/{zipFile}", name="app_remove_archive")
     */
    public function removeArchiveAction($app, $zipFile)
    {
        /* @var $archive \Elendev\AppManagerBundle\AppManager\AppArchive */
        $archive = $this->get("elendev.app_manager.apps_manager")->getApp($app)->getArchive($zipFile);
        
        $fs = new Filesystem();
        $fs->remove($archive->getPath());
            
        $this->get('session')->getFlashBag()->add(
            'notice',
            'The ' . $zipFile . ' from ' . $app . ' has been removed '
        );
        
        return $this->redirect($this->generateUrl("app_index", array('app' => $app)));
    }
    
    
    /**
     * @Route("/app/removeVersion/{app}/{appVersion}", name="app_remove_version")
     */
    public function removeVersionAction($app, $appVersion)
    {
        /* @var $version \Elendev\AppManagerBundle\AppManager\AppVersion */
        $version = $this->get("elendev.app_manager.apps_manager")->getApp($app)->getVersion($appVersion);
        
        $fs = new Filesystem();
        $fs->remove($version->getPath());
            
        $this->get('session')->getFlashBag()->add(
            'notice',
            'The ' . $appVersion . ' from ' . $app . ' has been removed '
        );
        
        return $this->redirect($this->generateUrl("app_index", array('app' => $app)));
    }
    
    
        
    /**
     * Actually set only prod env as public
     * @Route("/app/setPublicVersion/{app}/{appVersion}", name="app_set_public_version")
     */
    public function setPublicAction($app, $appVersion)
    {   
        /* @var $currentApp \Elendev\AppManagerBundle\AppManager\App */
        $currentApp = $this->get("elendev.app_manager.apps_manager")->getApp($app);
        /* @var $version \Elendev\AppManagerBundle\AppManager\AppVersion */
        $version = $currentApp->getVersion($appVersion);
        
        
        $publisher = $this->get("elendev.app_manager.publisher");
            
        try{
            $publisher->publish($version);
            
            $this->get('session')->getFlashBag()->add(
                'notice',
                'The ' . $appVersion . ' from ' . $app . ' has been published ! '
            );
        }catch(\Exception $e){
            $this->get('session')->getFlashBag()->add(
                'error',
                "An error occured while trying to publish " . $app . " " . $appVersion . " : " . $e->getMessage()
            );
        }
        
        return $this->redirect($this->generateUrl("app_index", array('app' => $app)));
    }
    
    
}
