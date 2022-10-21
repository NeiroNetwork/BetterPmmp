<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class ArrowHitSound implements Listener{

	/**
	 * @priority MONITOR
	 */
	public function onEntityDamageByChildEntity(EntityDamageByChildEntityEvent $event) : void{
		if($event->getChild() instanceof Arrow){
			$damager = $event->getDamager();
			if($damager instanceof Player){
				$damager->getNetworkSession()->sendDataPacket($this->sound($damager->getPosition()));
			}
		}
	}

	private function sound(Vector3 $pos) : PlaySoundPacket{
		return PlaySoundPacket::create("random.orb", $pos->x, $pos->y, $pos->z, 1.0, 1.0);
	}
}
