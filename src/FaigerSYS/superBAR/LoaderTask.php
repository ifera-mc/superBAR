<?php

namespace FaigerSYS\superBAR;

use pocketmine\scheduler\Task;

class LoaderTask extends Task{
	
	private $loader;
	
	/**
	 * LoaderTask constructor.
	 *
	 * @param superBAR $plugin
	 * @param Loader   $loader
	 */
	public function __construct(superBAR $plugin, Loader $loader){
		$this->loader = $loader;
	}
	
	/**
	 * @param int $tick
	 */
	public function onRun(int $tick){
		$this->loader->onEnable();
	}
	
}
