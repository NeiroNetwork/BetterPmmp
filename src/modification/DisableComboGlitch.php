<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPocketMine\modification;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;

class DisableComboGlitch implements Listener{

	/**
	 * @priority LOWEST
	 */
	public function onDamage(EntityDamageByEntityEvent $event) : void{
		if($event->isApplicable(EntityDamageEvent::MODIFIER_PREVIOUS_DAMAGE_COOLDOWN)){
			$event->cancel();
		}
	}
}
