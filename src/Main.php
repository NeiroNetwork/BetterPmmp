<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use NeiroNetwork\BetterPmmp\modification\RestrictColoredText;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	protected function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents(new RestrictColoredText, $this);
	}
}
