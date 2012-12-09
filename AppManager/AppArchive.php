<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elendev\AppManagerBundle\AppManager;

/**
 * Description of AppArchive
 *
 * @author jonas
 */
class AppArchive {
    //put your code here
    private $path;
    
    private $name;
    
    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
}

