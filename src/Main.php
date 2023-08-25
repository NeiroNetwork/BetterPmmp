<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use NeiroNetwork\BetterPmmp\modification\ModuleBase;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Symfony\Component\Filesystem\Path;

class Main extends PluginBase{

	protected function onEnable() : void{
		$config = new Config(Path::join($this->getDataFolder(), "config.yml"), default: [
			"AddEducationItems" => true,
			"ArrowHitSound" => true,
			"DisableBreakingBySpectator" => true,
			"DisableComboGlitch" => true,
			"FixFallDamageHeight" => true,
			"FixGhostWater" => true,
			"LimitedEnderPearl" => true,
			"RestrictColoredText" => true,
			"SimplePlayerList" => true,
			"SuppressSelfEmoteText" => true,
		]);

		foreach($config->getAll() as $module => $enable){
			if(!$enable) continue;

			$class = "NeiroNetwork\\BetterPmmp\\modification\\$module";
			if(class_exists($class) && is_subclass_of($class, ModuleBase::class)){
				$instance = new $class();
				if($instance->canEnable()){
					$this->getServer()->getPluginManager()->registerEvents($instance, $this);
					$instance->onEnabled();
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
