<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Elendev\AppManagerBundle\AppManager;
/**
 * Description of AppVersion
 *
 * @author jonas
 */
class AppVersion {
	
	const TYPE_DIRECTORY = "DIRECTORY";
	const TYPE_PHAR = "PHAR";
	
	private $app;

	private $name;
	private $path;
	private $url;
	private $environments;

	private $consolePath;

	private $commandFactory;

	private $type;

	public function __construct(App $app) {
		$this->app = $app;
	}

	/**
	 *
	 * @return Console\CommandFactory
	 */
	public function getCommandFactory() {
		return $this->commandFactory;
	}

	public function setCommandFactory($commandFactory) {
		$this->commandFactory = $commandFactory;
	}

	/*
	 * @return Elendev\AppManagerBundle\AppManager\App
	 */
	public function getApp() {
		return $this->app;
	}

	public function setApp($app) {
		$this->app = $app;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getPath() {
		return $this->path;
	}

	public function setPath($path) {
		$this->path = $path;
	}

	public function getUrl() {
		return $this->url;
	}

	public function setUrl($url) {
		$this->url = $url;
	}
	public function getEnvironments() {
		return $this->environments;
	}

	public function setEnvironments($environments) {
		$this->environments = $environments;
	}

	public function getConsolePath() {
		return $this->consolePath;
	}

	public function setConsolePath($consolePath) {
		$this->consolePath = $consolePath;
	}

	public function getEnvironment($environment) {
		foreach ($this->environments as $env) {
			if ($env->getName() == $environment) {
				return $env;
			}
		}
		return null;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}

}

