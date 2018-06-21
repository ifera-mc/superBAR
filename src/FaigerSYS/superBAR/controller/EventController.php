<?php

namespace FaigerSYS\superBAR\controller;

use FaigerSYS\superBAR\BaseModule;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;

class EventController extends BaseModule implements Listener{
	
	/**
	 * @param PlayerJoinEvent $e
	 * @priority MONITOR
	 */
	public function onJoin(PlayerJoinEvent $e){
		$player = $e->getPlayer();
		$display = ($this->getPlugin()->isDefaultEnabled() && $this->getPlugin()->hasPermission($player, 'use'));
		$this->getPlugin()->getHUD()->setDisplay($player->getName(), $display);
	}
	
	/**
	 * @param PlayerRespawnEvent $e
	 * @priority MONITOR
	 */
	public function onRespawn(PlayerRespawnEvent $e){
		$player = $e->getPlayer();
		$display = ($this->getPlugin()->isDefaultEnabled() && $this->getPlugin()->hasPermission($player, 'use'));
		$this->getPlugin()->getHUD()->setDisplay($player->getName(), $display);
	}
	
	/**
	 * @param PlayerQuitEvent $e
	 * @priority MONITOR
	 */
	public function onLogout(PlayerQuitEvent $e){
		$this->getPlugin()->getHUD()->setDisplay($e->getPlayer()->getName(), false);
	}
	
}
