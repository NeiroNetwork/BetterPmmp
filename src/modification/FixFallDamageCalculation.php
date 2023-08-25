<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\player\PlayerCreationEvent;

class FixFallDamageCalculation extends ModuleBase{

	public function onPlayerCreation(PlayerCreationEvent $event) : void{
		if(!class_exists("pocketmine\player\Player​")){
			$this->initPlayerClass($event->getPlayerClass());
		}
		$event->setPlayerClass("pocketmine\player\Player​");
	}

	private function initPlayerClass(string $playerClass) : void{
		if(!str_starts_with($playerClass, "\\")){
			$playerClass = "\\" . $playerClass;
		}
		eval(
'namespace pocketmine\player{
	use pocketmine\entity\effect\VanillaEffects;
	class Player​ extends ' . $playerClass . '{
		protected function calculateFallDamage(float $fallDistance) : float{
			return ceil($fallDistance - 3.3462697267 - $this->effectManager->get(VanillaEffects::JUMP_BOOST())?->getEffectLevel());
		}
	}
}'
		);
	}
}
