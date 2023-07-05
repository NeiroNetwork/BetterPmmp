<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\types\AbilitiesLayer;
use pocketmine\network\mcpe\protocol\UpdateAbilitiesPacket;
use ReflectionClass;

/**
 * @see https://github.com/pmmp/PocketMine-MP/pull/5313
 */
class DisableBreakingBySpectator implements Listener{

	public function onPacketSend(DataPacketSendEvent $event) : void{
		foreach($event->getPackets() as $packet){
			if($packet::NETWORK_ID !== UpdateAbilitiesPacket::NETWORK_ID) continue;
			/** @var UpdateAbilitiesPacket $packet */
			$property = (new ReflectionClass($packet->getData()))->getProperty("abilityLayers");
			$layers = $property->getValue($packet->getData());
			$layers[] = new AbilitiesLayer(AbilitiesLayer::LAYER_SPECTATOR, [
				AbilitiesLayer::ABILITY_OPERATOR => false,
			], null, null);
			$property->setValue($packet, $layers);
		}
	}
}
