<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class ArrowHitSound implements Module{

	public function canEnable() : bool{
		return true;
	}

	/**
	 * @priority MONITOR
	 */
	public function onEntityDamageByChildEntity(EntityDamageByChildEntityEvent $event) : void{
		if($event->getChild() instanceof Arrow){
			$damager = $event->getDamager();
			if($damager instanceof Player){
				$this->playHitSound($damager);
			}
		}
	}

	private function playHitSound(Player $player) : void{
		$position = $player->getPosition();
		$packet = PlaySoundPacket::create("random.orb", $position->x, $position->y, $position->z, 1.0, 1.0);
		$player->getNetworkSession()->sendDataPacket($packet);
	}
}
