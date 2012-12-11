<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


namespace Elendev\AppManagerBundle\AppManager;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Elendev\AppManagerBundle\AppManager\Console\CommandFactory;
use Elendev\AppManagerBundle\AppManager\Console\Command;
use Elendev\AppManagerBundle\AppManager\Console\CommandModel;
use Elendev\AppManagerBundle\AppManager\Console\ConsoleFactory;
use Elendev\AppManagerBundle\AppManager\Publisher\Publisher;

class AppsManager{
    
    private $apps;
    
    private $appsConfig;
    
    private $consoleFactory;
    
    /* @var $logger \Symfony\Bridge\Monolog\Logger */
    private $logger;
    
    /* @var $publisher Publisher; */
    private $publisher;
    
    public function __construct($logger, $apps, ConsoleFactory $consoleFactory, Publisher $publisher){
        
        $this->consoleFactory = $consoleFactory;
        
        $this->publisher = $publisher;
        
        $this->logger = $logger;
        
        $this->apps = array();
        $this->appsConfig = array();
        
        foreach($apps as $appConfig){
            $this->appsConfig[$appConfig["name"]] = $appConfig;
            $this->apps[$appConfig["name"]] = null;
        }
    }
    
    
    public function getAppsName(){
        return array_keys($this->apps);
    }
    
    /*
     * @return App
     */
    public function getApp($appName){
        if(!array_key_exists($appName, $this->apps)){
            $this->logger->err("App $appName not found in AppsManager::apps array");
            throw new \Exception("App $appName not found !");
        }
        
        if(!isset($this->apps[$appName])){
            
            $app = new App();
            
            $appConfig = $this->appsConfig[$appName];
            
            $app->setName($appConfig["name"]);
            $app->setPath($appConfig["path"]);
            $app->setUrl($appConfig["url"]);
            
            if(array_key_exists("publishingPath", $appConfig)){
                $app->setPublishingPath($appConfig["publishingPath"]);
            }else{
                $app->setPublishingPath($appConfig["path"]);
            }
            
            $this->completeApp($app);
            
            $this->apps[$appName] = $app;
        }
        
        return $this->apps[$appName];
    }
    
    /**
     * Construct app from informations
     * @param type $path
     */
    private function completeApp(App $app){
        
        $finder = new Finder();
        $finder->in($app->getPath())->directories()->depth('== 0')->sortByName();
        
        $appVersions = array();
        
        foreach($finder as $versionDirectory){
            /* @var $versionDirectory SplFileInfo */
            
            $appVersion = new AppVersion($app);
            $appVersion->setPath($versionDirectory->getRealPath());
            $appVersion->setName($versionDirectory->getBasename());
            $appVersion->setUrl($app->getUrl() . "/" . $versionDirectory->getBasename());
            
            
            if(file_exists($appVersion->getPath() . "/web")){
                $this->completeVersion($appVersion);
                $appVersions[$appVersion->getName()] = $appVersion;
            }else{
                $this->logger->warn("Invalid version directory  " . $versionDirectory->getBasename() . " for " .$app->getName() . " (complete path : " . $versionDirectory->getRealPath() . ")");
            }
            
        }
        
        $app->setVersions(array_reverse($appVersions));
        
        $app->setPublishedVersion($this->publisher->getPublishedVersion($app));
        
        
        $finder = new Finder();
        $finder->in($app->getPath())->files()->depth('== 0')->name("*.zip")->sortByName();
        
        $appArchives = array();
        
        foreach($finder as $archiveFile){
            /* @var $archiveFile SplFileInfo */
            $archive = new AppArchive();
            $archive->setPath($archiveFile->getRealPath());
            $archive->setName($archiveFile->getBasename());
            $appArchives[] = $archive;
        }
        
        $app->setArchives(array_reverse($appArchives));
        
    }
    
    private function completeVersion(AppVersion $appVersion){
        if(file_exists($appVersion->getPath() . "/app/console")){
            $appVersion->setConsolePath($appVersion->getPath() . "/app/console");
            $this->createCommandFactory($appVersion);
        }
        
        $environmentFinder = new Finder();
        $environmentFinder->in($appVersion->getPath() . "/web" )->depth('== 0')->files()->name("app*.php");

        $environments = array();

        foreach($environmentFinder as $environment){
            /* @var $environment SplFileInfo */
            $env = new AppEnvironment($appVersion);

            $env->setPath($environment->getRealPath());
            $env->setName($this->getEnvironmentName($environment->getBasename(".php")));
            $env->setUrl($appVersion->getUrl() . "/web/" . $environment->getBasename());

            $environments[] = $env;
        }

        $appVersion->setEnvironments($environments);
    }
    
    private function createCommandFactory(AppVersion $appVersion){
        //command
        $commandFactory = new CommandFactory();
        $appVersion->setCommandFactory($commandFactory);
        
        $result = $this->consoleFactory->getConsole($appVersion)->exec(new Command("list", array(), array("--raw" => null)));
        
        if($result->getStatus() != 0)
            return;
            
        
        $commandModels = array();
        
        foreach($result->getResult() as $commandLine){
            $splited = explode(" ", trim($commandLine));
            
            $commandName = trim($splited[0]);
            
            $description = trim(substr(trim($commandLine), count($commandName)));
            
            $commandModels[$commandName] = new CommandModel($commandName);
            $commandModels[$commandName]->setDescription($description);
        }
        
        $commandFactory->setCommandModels($commandModels);
    }
    
    
    private function getEnvironmentName($name){
        if($name == 'app'){
            return 'prod';
        }else{
            $parts = explode('_', $name);
            return $parts[1];
        }
    }
}
