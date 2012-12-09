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
class Console {
    //put your code here
    /*
     * @type AppVersion
     */
    private $appVersion;
    
    private $phpPath;
    
    
    /* @var $logger \Symfony\Bridge\Monolog\Logger */
    private $logger;
    
    public function __construct(AppVersion $appVersion, $phpPath = "php", $logger = null){
        $this->phpPath = $phpPath;
        $this->appVersion = $appVersion;
        $this->logger = $logger;
    }
    
    
    /**
     * Exec a simple symfony console command
     * @param type $command
     * @return ConsoleResult
     */
    public function exec(Command $command){
        $results = array();
        $status = null;
        
        //die("command :" . $command->getCommandString());
        $commandFull = $this->phpPath . " " . $this->appVersion->getConsolePath() . " " . $command->getCommandString();
        $result = exec($commandFull, $results, $status);
        
        $consoleResult = new CommandResult($this->appVersion, $command, $commandFull, $result, $results, $status);
        
        
        if($consoleResult->getStatus() != 0 && $this->logger){
            $this->logger->err("Command execution error : " . $command->getCommand() . " (return status : " . $consoleResult->getStatus() . " - Command : " . $commandFull . ")",
                    $consoleResult->getResult());
        }
        
        return $consoleResult;
    }
    
}

