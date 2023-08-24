<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\entity\EntityDamageEvent;

class FixFallDamageHeight extends ModuleBase{

	/**
	 * @priority LOWEST
	 */
	public function onEntityDamage(EntityDamageEvent $event) : void{
		if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
			if($event->getEntity()->getFallDistance() <= 3.3462697267){
				$event->cancel();
			}
		}
	}
}
