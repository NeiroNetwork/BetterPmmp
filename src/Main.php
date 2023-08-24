<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use NeiroNetwork\BetterPmmp\modification\Module;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Symfony\Component\Filesystem\Path;

class Main extends PluginBase{

	protected function onEnable() : void{
		$config = new Config(Path::join($this->getDataFolder(), "config.yml"), default: [
			"RestrictColoredText" => true,
			"DisableComboGlitch" => true,
			"SimplePlayerList" => true,
			"LimitedEnderPearl" => true,
			"FixFallDamageHeight" => true,
			"DisableBreakingBySpectator" => true,
			"ArrowHitSound" => true,
			"FixGhostWater" => true,
			"SuppressEmoteText" => true,
		]);

		foreach($config->getAll() as $module => $enable){
			if(!$enable) continue;

			$class = "NeiroNetwork\\BetterPmmp\\modification\\$module";
			if(class_exists($class) && is_subclass_of($class, Module::class)){
				$instance = new $class();
				if($instance->isLoadable()){
					$this->getServer()->getPluginManager()->registerEvents($instance, $this);
				}
			}else{
				$this->getLogger()->error("Module \"$module\" not found");
				$config->remove($module);
			}
		}

		if($config->hasChanged()){
			$config->save();
		}
	}
}
