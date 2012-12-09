<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Elendev\AppManagerBundle\AppManager\Console;
/**
 * Description of CommandModel
 *
 * @author jonas
 */
class CommandModel {
    //put your code here

    private $command;
    private $description;
    
    private $arguments;
    private $options;
    
    public function __construct($command, $description = null){
        $this->command = $command;
        $this->description = $description;
    }
    
    public function getCommand() {
        return $this->command;
    }

    public function setCommand($command) {
        $this->command = $command;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function setArguments($arguments) {
        $this->arguments = $arguments;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }


    
}
