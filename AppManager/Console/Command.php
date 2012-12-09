<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elendev\AppManagerBundle\AppManager\Console;

/**
 * Description of Command
 *
 * @author jonas
 */
class Command {
    private $arguments;
    private $options;
    
    private $command;
    
    private $commandString;
    
    
    public function __construct($command, $arguments, $options){
        $this->command = $command;
        $this->arguments = $arguments;
        $this->options = $options;
        
        $this->generateCommand();
    }
    
    public function getCommandString(){
        return $this->commandString;
    }
    
    private function generateCommand(){
        $cleanInput = function($argument){
            return escapeshellarg($argument);
        };
        
        $cleanOptions = function($option, $value){
            if($value){
                return $option . "=" . escapeshellarg($value);
            }else{
                return $option;
            }
        };
        
        
        $argumentsLine = "";
        if($this->arguments != null && count($this->arguments) > 0){
            $argumentsLine = " " . implode(" ", array_map($cleanInput, $this->getArguments()));
        }
        
        $optionsLine = "";
        if($this->options != null && count($this->options) > 0){
            $optionsLine = " " . implode(" ", array_map($cleanOptions, array_keys($this->getOptions()), array_values($this->getOptions())));
        }
        
        
        $this->commandString = $this->getCommand() . $argumentsLine . $optionsLine;
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

    public function getCommand() {
        return $this->command;
    }

    public function setCommand($command) {
        $this->command = $command;
    }
}


