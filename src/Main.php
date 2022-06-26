<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use NeiroNetwork\BetterPmmp\modification\DisableComboGlitch;
use NeiroNetwork\BetterPmmp\modification\RestrictColoredText;
use NeiroNetwork\BetterPmmp\modification\VanillaLikeChat;
use NeiroNetwork\BetterPmmp\modification\SimplePlayerList;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	protected function onEnable() : void{
		$mods = [];
		$config = $this->getConfig();

		if($config->get("RestrictColoredText")) $mods[] = new RestrictColoredText;
		if($config->get("DisableComboGlitch")) $mods[] = new DisableComboGlitch;
		if($config->get("SimplePlayerList")) $mods[] = new SimplePlayerList;
		if($config->get("VanillaLikeChat")) $mods[] = new VanillaLikeChat;

		foreach($mods as $listener){
			$this->getServer()->getPluginManager()->registerEvents($listener, $this);
		}
	}
}
