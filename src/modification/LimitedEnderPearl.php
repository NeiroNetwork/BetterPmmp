<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\entity\projectile\EnderPearl;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\player\Player;
use pocketmine\world\World;

class LimitedEnderPearl implements Module{

	public function canEnable() : bool{
		return true;
	}

	/**
	 * @priority MONITOR
	 */
	public function onPlayerDeath(PlayerDeathEvent $event) : void{
		$this->killEnderPearl($event->getPlayer());
	}

	private function killEnderPearl(Player $player, World $world = null) : void{
		// クリエイティブのプレイヤーが投げたエンダーパールはキルしない
		if(!$player->hasFiniteResources()) return;

		foreach(($world ?? $player->getWorld())->getEntities() as $entity){
			if($entity->getOwningEntityId() === $player->getId() && $entity instanceof EnderPearl){
				$entity->setOwningEntity(null);
				// どっちがいい？
				// $entity->kill();
			}
		}
	}

	/**
	 * @priority MONITOR
	 */
	public function onEntityTeleport(EntityTeleportEvent $event) : void{
		$entity = $event->getEntity();
		$from = $event->getFrom()->getWorld();
		$to = $event->getTo()->getWorld();
		if($entity instanceof Player && $from !== $to) $this->killEnderPearl($entity, $from);
	}
}
