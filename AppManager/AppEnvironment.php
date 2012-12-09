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
