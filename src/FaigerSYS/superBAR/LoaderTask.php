<?php

namespace FaigerSYS\superBAR;

use pocketmine\scheduler\PluginTask;

class LoaderTask extends PluginTask
{

    private $loader;

    /**
     * LoaderTask constructor.
     * @param superBAR $plugin
     * @param Loader $loader
     */
    public function __construct(superBAR $plugin, Loader $loader)
    {
        $this->loader = $loader;
        parent::__construct($plugin);
    }

    /**
     * @param int $tick
     */
    public function onRun(int $tick)
    {
        $this->loader->onEnable($this->getOwner());
    }

}
