<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\types\UpdateAbilitiesPacketLayer;
use pocketmine\network\mcpe\protocol\UpdateAbilitiesPacket;

/**
 * @see https://github.com/pmmp/PocketMine-MP/pull/5313
 */
class DisableBreakingBySpectator implements Listener{

	public function onPacketSend(DataPacketSendEvent $event){
		foreach($event->getPackets() as $packet){
			if($packet::NETWORK_ID !== UpdateAbilitiesPacket::NETWORK_ID) continue;
			/** @var UpdateAbilitiesPacket $packet */
			$property = (new \ReflectionClass($packet))->getProperty("abilityLayers");
			$property->setAccessible(true);
			$layers = $property->getValue($packet);
			$layers[] = new UpdateAbilitiesPacketLayer(UpdateAbilitiesPacketLayer::LAYER_SPECTATOR, [
				UpdateAbilitiesPacketLayer::ABILITY_OPERATOR => false,
			], null, null);
			$property->setValue($packet, $layers);
		}
	}
}
