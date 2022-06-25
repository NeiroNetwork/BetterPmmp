<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPocketMine;

use NeiroNetwork\BetterPocketMine\modification\RestrictColoredText;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	protected function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents(new RestrictColoredText, $this);
	}
}
