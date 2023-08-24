<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;

abstract class ModuleBase implements Listener{

	final public function __construct(){
		// Do not use and override the constructor
	}

	public function canEnable() : bool{
		return true;
	}

	public function onEnabled() : void{
	}
}
