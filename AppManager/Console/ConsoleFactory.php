<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elendev\AppManagerBundle\AppManager\Console;

use Elendev\AppManagerBundle\AppManager\AppVersion;

/**
 * Description of Console
 *
 * @author jonas
 */
class ConsoleFactory {
    //put your code here
    private $phpPath;
    
    /* @var $logger \Symfony\Bridge\Monolog\Logger */
    private $logger;
    
    public function __construct($logger, $phpPath = "php"){
        $this->phpPath = $phpPath;
        $this->logger = $logger;
    }
    
    
    /**
     * 
     * @param \Elendev\AppManagerBundle\AppManager\AppVersion $appVersion
     * @return ConsoleResult
     */
    public function getConsole(AppVersion $appVersion){
        return new Console($appVersion, $this->phpPath, $this->logger);
    }
}

