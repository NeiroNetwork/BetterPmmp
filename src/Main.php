<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	protected function onEnable() : void{
		foreach($this->getConfig()->getAll() as $key => $value){
			if($value){
				$class = "\\NeiroNetwork\\BetterPmmp\\modification\\$key";
				$this->getServer()->getPluginManager()->registerEvents(new $class, $this);
			}
		}
	}
}
