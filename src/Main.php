<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Symfony\Component\Filesystem\Path;

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
			"ArrowHitSound" => true,
		]);

		foreach($config->getAll() as $key => $value){
			if(!$value) continue;

			$class = "\\NeiroNetwork\\BetterPmmp\\modification\\$key";
			if(!class_exists($class)){
				$this->getLogger()->error("Module \"$key\" not found");
				$config->remove($key);
				$config->save();
				continue;
			}

			$this->getServer()->getPluginManager()->registerEvents(new $class, $this);
		}
	}
}
