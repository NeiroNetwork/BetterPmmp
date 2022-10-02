<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Webmozart\PathUtil\Path;

class Main extends PluginBase{

	protected function onEnable() : void{
		$config = new Config(Path::join($this->getDataFolder(), "config.yml"), default: [
			"RestrictColoredText" => true,
			"DisableComboGlitch" => true,
			"SimplePlayerList" => true,
			"VanillaLikeChat" => true,
			"LimitedEnderPearl" => true,
			"FixFallDamageHeight" => true,
			"DisableBreakingBySpectator" => true,
		]);

		foreach($config->getAll() as $key => $value){
			if($value){
				$class = "\\NeiroNetwork\\BetterPmmp\\modification\\$key";
				if(!class_exists($class)){
					$this->getLogger()->error("Module \"$key\" not found");
					$config->remove($key);
					continue;
				}
				$this->getServer()->getPluginManager()->registerEvents(new $class, $this);
			}
		}
	}
}
