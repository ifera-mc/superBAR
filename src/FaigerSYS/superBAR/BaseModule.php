<?php

namespace FaigerSYS\superBAR;

abstract class BaseModule{
	
	private static $plugin = null;
	
	/**
	 * @param superBAR $plugin
	 */
	public static function setPlugin(superBAR $plugin){
		BaseModule::$plugin = $plugin;
	}
	
	/**
	 * @return superBAR|null
	 */
	protected function getPlugin(): superBAR{
		return BaseModule::$plugin;
	}
}
