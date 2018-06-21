<?php

namespace FaigerSYS\superBAR\controller;

use FaigerSYS\superBAR\core\HUD;
use FaigerSYS\superBAR\provider\AddonProvider;
use FaigerSYS\superBAR\provider\ConfigProvider;

class DataController{
	
	/** @var HUD */
	private $HUD = null;
	
	/** @var ConfigProvider */
	private $configProvider = null;
	
	/** @var AddonProvider */
	private $addonProvider = null;
	
	/** @var EventController */
	private $eventController = null;
	
	/** @var bool */
	private $defaultEnabled = true;
	
	/**
	 * @return HUD
	 */
	public function getHUD(){
		return $this->HUD;
	}
	
	/**
	 * @param HUD $HUD
	 */
	public function setHUD(HUD $HUD){
		$this->HUD = $HUD;
	}
	
	/**
	 * @return ConfigProvider
	 */
	public function getConfigProvider(){
		return $this->configProvider;
	}
	
	/**
	 * @param ConfigProvider $provider
	 */
	public function setConfigProvider(ConfigProvider $provider){
		$this->configProvider = $provider;
	}
	
	/**
	 * @return AddonProvider
	 */
	public function getAddonProvider(){
		return $this->addonProvider;
	}
	
	/**
	 * @param AddonProvider $provider
	 */
	public function setAddonProvider(AddonProvider $provider){
		$this->addonProvider = $provider;
	}
	
	/**
	 * @return EventController
	 */
	public function getEventController(){
		return $this->eventController;
	}
	
	/**
	 * @param EventController $controller
	 */
	public function setEventController(EventController $controller){
		$this->eventController = $controller;
	}
	
	/**
	 * @return bool
	 */
	public function isDefaultEnabled(){
		return $this->defaultEnabled;
	}
	
	/**
	 * @param bool $state
	 */
	public function setDefaultEnabled(bool $state){
		$this->defaultEnabled = $state;
	}
	
}
