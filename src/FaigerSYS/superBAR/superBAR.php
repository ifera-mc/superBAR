<?php

namespace FaigerSYS\superBAR;

use FaigerSYS\superBAR\controller\CommandController;
use FaigerSYS\superBAR\core\HUD;
use FaigerSYS\superBAR\provider\ConfigProvider;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as CLR;

class superBAR extends PluginBase{
	
	const PREFIX = CLR::AQUA . '[' . CLR::YELLOW . 'super' . CLR::GOLD . 'BAR' . CLR::AQUA . '] ' . CLR::GRAY;
	const NO_PERM = CLR::RED . 'You do not have permission to use this command';
	
	/** @var Loader */
	private static $loader = null;
	
	public function onEnable(){
		$this->getLogger()->info(CLR::GOLD . 'superBAR will be enabled after the complete server load');
		BaseModule::setPlugin($this);
		!(superBAR::$loader instanceof Loader) ? superBAR::$loader = new Loader() : false;
		$this->getScheduler()->scheduleDelayedTask(new LoaderTask($this, superBAR::$loader), 0);
	}
	
	/**
	 * @param CommandSender $sender
	 * @param Command       $command
	 * @param string        $label
	 * @param array         $args
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
		CommandController::executeCommand($this, $sender, $args);
		return true;
	}
	
	/**
	 * Reload settings
	 */
	public function reloadSettings(){
		superBAR::$loader->loadAll(true);
	}
	
	/**
	 * Get settings descriprion
	 *
	 * @return array
	 */
	public function getSettingsDescription(){
		return $this->getConfigProvider()->getSettingsDescription();
	}
	
	/**
	 * Get config provider
	 *
	 * @return ConfigProvider
	 */
	public function getConfigProvider(){
		return superBAR::$loader->getData()->getConfigProvider();
	}
	
	/**
	 * Get HUD core
	 *
	 * @return HUD
	 */
	public function getHUD(){
		return superBAR::$loader->getData()->getHUD();
	}
	
	/**
	 * Change timezone
	 *
	 * @param bool $timezone
	 * @return bool
	 */
	public function setTimezone($timezone = false){
		return ($timezone ? @date_default_timezone_set($timezone) : false);
	}
	
	/**
	 * Enable HUD for default
	 *
	 * @param bool $state
	 */
	public function setDefaultEnabled(bool $state){
		superBAR::$loader->getData()->setDefaultEnabled($state);
	}
	
	/**
	 * Is HUD enabled for default
	 *
	 * @return bool
	 */
	public function isDefaultEnabled(){
		return superBAR::$loader->getData()->isDefaultEnabled();
	}
	
	/**
	 * @param CommandSender $object
	 * @param string        $permission
	 * @return bool
	 */
	public function hasPermission(CommandSender $object, string $permission){
		return ($object->hasPermission('superbar') || $object->hasPermission('superbar.' . $permission));
	}
	
	/**
	 * @param string $text
	 */
	public function sendLog(string $text){
		return $this->getLogger()->info(superBAR::PREFIX . $text);
	}
	
	public function onDisable(){
		superBAR::$loader->onDisable();
	}
	
}
