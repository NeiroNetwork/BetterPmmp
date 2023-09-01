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
			"FixFallDamageCalculation" => false,
			"FixFallDamageHeight" => true,
			"FixGhostWater" => true,
			"LimitedEnderPearl" => true,
			"RestrictColoredText" => true,
			"SimplePlayerList" => true,
			"SuppressSelfEmoteText" => true,
		]);

		foreach($config->getAll() as $module => $enable){
			$class = "NeiroNetwork\\BetterPmmp\\modification\\$module";
			if(!class_exists($class) || !is_subclass_of($class, ModuleBase::class)){
				$this->getLogger()->error("Module \"$module\" not found");
				$config->remove($module);
				continue;
			}

			if($enable){
				$instance = new $class();
				if($instance->canEnable()){
					$this->getServer()->getPluginManager()->registerEvents($instance, $this);
					$instance->onEnabled();
				}
			}
		}

		if($config->hasChanged()){
			$config->save();
		}
	}
}
