<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Elendev\AppManagerBundle\AppManager\Publisher;
use Elendev\AppManagerBundle\AppManager\App;
use Elendev\AppManagerBundle\AppManager\AppVersion;
use Symfony\Component\Filesystem\Filesystem;
/**
 * Description of SymlinkPublisher
 *
 * @author jonas
 */
class SymlinkPublisher implements Publisher{
    
    /* @var $logger \Symfony\Bridge\Monolog\Logger */
    private $logger;
    
    public function __construct($logger){
        $this->logger = $logger;
    }
    
    public function publish(AppVersion $version){
        
        $app = $version->getApp();
        
        if(file_exists($app->getPublishingPath()) && !is_link($app->getPublishingPath())){
            $this->logger->err("Can't publish " . $app->getName() . " - create a link, file " . $app->getPublishingPath() . " already exist and is not a symlink !");
            throw new \Exception("Can't create a link, file " . $app->getPublishingPath() . " already exist and is not a symlink !");
        }
        
        $fs = new Filesystem();
        
        $fs->remove($app->getPublishingPath());
        $fs->symlink($version->getPath() . "/web", $app->getPublishingPath());
        
    }

    public function getPublishedVersion(App $app) {
        
        if(is_link($app->getPublishingPath())){
            $versionPath = readlink($app->getPublishingPath());
            
            foreach($app->getVersions() as $v){
                if($v->getPath() . "/web" == $versionPath){
                    return $v;
                }
            }
        }
        
        return null;
        
    }
}

