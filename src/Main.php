<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp;

use NeiroNetwork\BetterPmmp\modification\ModuleBase;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Symfony\Component\Filesystem\Path;

final class Main extends PluginBase{

	/** @var ModuleBase[] */
	private array $modules = [];

	protected function onLoad() : void{
		$config = new Config(Path::join($this->getDataFolder(), "config.yml"), default: [
			"AddEducationItems" => true,
			"ArrowHitSound" => true,
			"BetterFlat" => true,
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

		foreach($config->getAll() as $moduleName => $enable){
			$class = "NeiroNetwork\\BetterPmmp\\modification\\$moduleName";
			if(!class_exists($class) || !is_subclass_of($class, ModuleBase::class)){
				$this->getLogger()->error("Module \"$moduleName\" not found");
				$config->remove($moduleName);
				continue;
			}

			if($enable){
				$this->modules[] = $module = new $class();
				$module->onLoad();
			}
		}

		if($config->hasChanged()){
			$config->save();
		}
	}

	protected function onEnable() : void{
		foreach($this->modules as $key => $module){
			if($module->canEnable()){
				$this->getServer()->getPluginManager()->registerEvents($module, $this);
				$module->onEnabled();
			}else{
				unset($this->modules[$key]);
			}
		}
	}
}
