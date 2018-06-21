<?php

namespace FaigerSYS\superBAR;

use FaigerSYS\superBAR\controller\DataController;
use FaigerSYS\superBAR\controller\EventController;
use FaigerSYS\superBAR\core\HUD;
use FaigerSYS\superBAR\core\HUDShowTask;
use FaigerSYS\superBAR\provider\AddonProvider;
use FaigerSYS\superBAR\provider\ConfigProvider;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat as CLR;

class Loader extends BaseModule{
	
	const PLUGINS = [['EconomyAPI', 'PocketMoney'], 'FactionsPro', 'GameTime', 'PurePerms', ['KillChat', 'ScorePvP']];
	
	public $plugins;
	/** @var superBAR */
	private $plugin;
	/** @var DataController */
	private $data = null;
	
	/** @var int */
	private $taskCache = null;
	
	public function onEnable(){
		$this->plugin = $this->getPlugin();
		$this->plugin->sendLog(CLR::GOLD . 'superBAR loading...');
		@mkdir($this->plugin->getDataFolder());
		if(!($this->data instanceof DataController)){
			$this->data = new DataController();
		}
		if(!(($events = $this->getData()->getEventController()) instanceof EventController)){
			$this->getData()->setEventController($events = new EventController());
		}
		$this->plugin->getServer()->getPluginManager()->registerEvents($events, $this->plugin);
		$this->loadAll();
		$this->plugin->sendLog(CLR::GOLD . 'superBAR by FaigerSYS enabled!');
	}
	
	/**
	 * @return DataController
	 */
	public function getData(){
		return $this->data;
	}
	
	/**
	 * @param bool $reload
	 */
	public function loadAll($reload = false){
		$settings = $this->getSettings();
		$this->plugin->setTimezone($settings['timezone']);
		$this->getData()->setDefaultEnabled($settings['default-enabled']);
		$timer = $settings['timer'];
		unset($settings['timezone']);
		unset($settings['default-enabled']);
		unset($settings['timer']);
		$this->plugins = $this->getPlugins($reload);
		$addons = $this->getAddons();
		if(!(($HUD = $this->getData()->getHUD()) instanceof HUD)){
			$this->getData()->setHUD($HUD = new HUD($settings, $this->plugins, $addons));
		}else{
			$HUD->setData($settings, $this->plugins, $addons);
		}
		$reload ? $this->plugin->getScheduler()->cancelTask($this->taskCache) : false;
		$this->taskCache = $this->plugin->getScheduler()->scheduleRepeatingTask(new HUDShowTask($this->plugin, $HUD), $timer)->getTaskId();
	}
	
	/**
	 * @return array
	 */
	private function getSettings(){
		if(!(($config = $this->getData()->getConfigProvider()) instanceof ConfigProvider)){
			$this->getData()->setConfigProvider($config = new ConfigProvider($this->getAnotherPlugin('PurePerms')));
		}else{
			$config->reloadData();
		}
		$settings = $config->getFormatedData();
		return $settings;
	}
	
	/**
	 * @param $name
	 * @return bool|null|Plugin
	 */
	private function getAnotherPlugin($name){
		if($plugin = $this->plugin->getServer()->getPluginManager()->getPlugin($name)){
			if($plugin->isEnabled()){
				return $plugin;
			}
		}
		return false;
	}
	
	/**
	 * @param bool $quiet
	 * @return array
	 */
	private function getPlugins($quiet = false){
		$this->plugins = [];
		foreach(Loader::PLUGINS as $names){
			if(is_array($names)){
				foreach($names as $name){
					if($this->plugins[$name] = $this->getAnotherPlugin($name)){
						!$quiet ? $this->plugin->sendLog(CLR::GREEN . $name . ' OK!') : false;
						break;
					}
				}
			}else{
				if($this->plugins[$names] = $this->getAnotherPlugin($names)){
					!$quiet ? $this->plugin->sendLog(CLR::GREEN . $names . ' OK!') : false;
				}
			}
		}
		return $this->plugins;
	}
	
	/**
	 * @return AddonProvider
	 */
	private function getAddons(){
		if(!(($addons = $this->getData()->getAddonProvider()) instanceof AddonProvider)){
			$this->getData()->setAddonProvider($addons = new AddonProvider());
		}else{
			$addons->reloadAddons();
		}
		return $addons;
	}
	
	public function onDisable(){
		$this->plugin->getScheduler()->cancelTask($this->taskCache);
	}
	
}
