<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elendev\AppManagerBundle\AppManager\Console;

/**
 * Description of CommandFactory
 *
 * @author jonas
 */
class CommandFactory {
    //put your code here
    
    private $commandModels = array();
    
    public function createCommand($command, $parameters, $options){
        
        if(!isset($this->commandModels[$command])){
            throw new \Exception("Command $command not available");
        }
        
        return new Command($command, $parameters, $options);
    }
    
    public function getCommandModels() {
        return $this->commandModels;
    }

    public function setCommandModels($commandModels) {
        $this->commandModels = $commandModels;
    }


}

