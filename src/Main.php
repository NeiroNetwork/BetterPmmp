<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use NeiroNetwork\BetterPmmp\modification\DisableComboGlitch;
use NeiroNetwork\BetterPmmp\modification\RestrictColoredText;
use NeiroNetwork\BetterPmmp\modification\VanillaLikeChat;
use NeiroNetwork\BetterPmmp\modification\VanillaLikePlayerList;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	protected function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents(new RestrictColoredText, $this);
		$this->getServer()->getPluginManager()->registerEvents(new DisableComboGlitch, $this);
		$this->getServer()->getPluginManager()->registerEvents(new VanillaLikePlayerList, $this);
		$this->getServer()->getPluginManager()->registerEvents(new VanillaLikeChat, $this);
	}
}
