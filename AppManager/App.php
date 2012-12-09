<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Elendev\AppManagerBundle\AppManager;

/**
 * Description of App
 *
 * @author jonas
 */
class App {
    private $name;
    private $url;
    private $path;
    
    private $versions = array();
    
    private $archives = array();
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getVersions() {
        return $this->versions;
    }

    public function setVersions($versions) {
        $this->versions = $versions;
    }

    public function getArchives() {
        return $this->archives;
    }

    public function setArchives($archives) {
        $this->archives = $archives;
    }
    
    /*
     * @return AppArchive
     */
    public function getArchive($name){
        foreach($this->archives as $archive){
            if($archive->getName() == $name){
                return $archive;
            }
        }
        return null;
    }
    
    /*
     * @return AppVersion
     */
    public function getVersion($name){
        foreach($this->versions as $version){
            if($version->getName() == $name){
                return $version;
            }
        }
        return null;
    }

}


