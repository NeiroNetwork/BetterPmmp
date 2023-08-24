<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

class DisableComboGlitch implements Module{

	public function isLoadable() : bool{
		return true;
	}

	/**
	 * @priority LOWEST
	 */
	public function onDamage(EntityDamageByEntityEvent $event) : void{
		if($event->getCause() !== EntityDamageEvent::CAUSE_ENTITY_ATTACK) return;
		if(!$event->isApplicable(EntityDamageEvent::MODIFIER_PREVIOUS_DAMAGE_COOLDOWN)) return;
		if(is_null($event->getDamager())) return;
		$last = $event->getEntity()->getLastDamageCause();
		if(!$last instanceof EntityDamageByEntityEvent) return;
		if($last->getDamager() !== $event->getDamager()) return;
		$event->cancel();
	}
}
