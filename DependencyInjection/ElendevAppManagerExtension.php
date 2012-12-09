<?php

namespace Elendev\AppManagerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ElendevAppManagerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        /*$configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        */
        $config = array();
        
        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }
        
        
        if(isset($config["apps"])){
            $container->setParameter("elendev.app_manager.apps", $config["apps"]);
        }
        
        $path = "php";
        
        if(isset($config["php_bin"])){
            $path = $config["php_bin"];
        }else{
            $phpPath = @$this->getPHPExecutableFromPath();
            
            if($phpPath){
                $path = $phpPath;
            }else{
                $container->get("logger")->warn("Can't find PHP executable");
            }
        }
        
        $container->setParameter("elendev.app_manager.php", $path);
        
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
    
    /*
     * return php path
     */
    private function getPHPExecutableFromPath() {
        
        if(defined(PHP_BINARY)){
            return PHP_BINARY;
        }
        
        $paths = explode(PATH_SEPARATOR, getenv('PATH'));
        foreach ($paths as $path) {
            // we need this for XAMPP (Windows)
            if (strstr($path, 'php.exe') && isset($_SERVER["WINDIR"]) && file_exists($path) && is_file($path)) {
                return $path;
            } else {
                $php_executable = $path . DIRECTORY_SEPARATOR . "php" . (isset($_SERVER["WINDIR"]) ? ".exe" : "");
                if (file_exists($php_executable) && is_file($php_executable)) {
                    return $php_executable;
                }
            }
        }
        return FALSE; // not found
    }
}
