<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elendev\AppManagerBundle\AppManager\Console;

use Elendev\AppManagerBundle\AppManager\AppVersion;
/**
 * Description of ConsoleResult
 *
 * @author jonas
 */
class CommandResult {
    
    private $response;
    private $result = array();
    private $status;
    private $commandFull;
    private $command;
    private $appVersion;
    
    
    public function __construct(AppVersion $appVersion, $command, $commandFull, $response, $result, $status){
        $this->appVersion = $appVersion;
        $this->command = $command;
        $this->commandFull = $commandFull;
        $this->response = $response;
        $this->result = $result;
        $this->status = $status;
    }
    
    public function getCommandFull() {
        return $this->commandFull;
    }
    
    public function getResponse() {
        return $this->response;
    }

    /**
     * @return array of result line
     */
    public function getResult() {
        return $this->result;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCommand() {
        return $this->command;
    }

    public function getAppVersion() {
        return $this->appVersion;
    }
}

