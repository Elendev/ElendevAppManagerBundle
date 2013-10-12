<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Elendev\AppManagerBundle\AppManager\Publisher;
use Elendev\AppManagerBundle\AppManager\AppVersion;
use Elendev\AppManagerBundle\AppManager\App;
/**
 * Description of HtaccessGenerator
 *
 * @author jonas
 */
interface Publisher {
    //put your code here
    
    public function publish(AppVersion $version);
    
    /**
     * return false if it's not published,
     * return version
     */
    public function getPublishedVersion(App $app);
}

