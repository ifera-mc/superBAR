<?php

namespace FaigerSYS\superBAR\core;

use FaigerSYS\superBAR\superBAR;
use pocketmine\scheduler\Task;

class HUDShowTask extends Task{
	
	private $plugin;
	private $HUD;
	
	/**
	 * HUDShowTask constructor.
	 *
	 * @param  $plugin
	 * @param  $HUD
	 */
	public function __construct(superBAR $plugin, HUD $HUD){
		$this->plugin = $plugin;
		$this->HUD = $HUD;
	}
	
	/**
	 * @param int $tick
	 */
	public function onRun(int $tick){
		$this->HUD->processHUD($this->plugin->getServer());
	}
	
	/**
	 * @return mixed
	 */
	public function getHUD(){
		return $this->HUD;
	}
	
	/**
	 * @param mixed $HUD
	 */
	public function setHUD($HUD){
		$this->HUD = $HUD;
	}
	
}
