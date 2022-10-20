<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class ArrowHitSound implements Listener {

	public function onEntityDamageByChildEntity(EntityDamageByChildEntityEvent $event){
		$child = $event->getChild();
		$entity = $event->getEntity();
		$damager = $event->getDamager();

		if ($child instanceof \pocketmine\entity\projectile\Arrow){
			if ($damager instanceof Player && $entity instanceof Player){
				$damager->getNetworkSession()->sendDataPacket($this->sound($damager->getPosition()));
			}
		}
	}

	private function sound(Vector3 $target): PlaySoundPacket{
		return PlaySoundPacket::create("random.orb", $target->x, $target->y, $target->z, 1.0, 0.5);
	}
}
