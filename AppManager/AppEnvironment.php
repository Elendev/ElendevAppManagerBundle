<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Elendev\AppManagerBundle\AppManager;
/**
 * Description of AppEnvironment
 *
 * @author jonas
 */
class AppEnvironment {
    //put your code here
    
    private $url;
    private $name;
    
    private $path;
    
    private $appVersion;
    
    public function __construct(AppVersion $appVersion){
        $this->appVersion = $appVersion;
    }
    
    /*
     * @return AppVersion AppVersion
     */
    public function getAppVersion() {
        return $this->appVersion;
    }

    public function setAppVersion($appVersion) {
        $this->appVersion = $appVersion;
    }
    
    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }


}
