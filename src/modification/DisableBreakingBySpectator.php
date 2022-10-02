<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\SetPlayerGameTypePacket;
use pocketmine\network\mcpe\protocol\types\GameMode;

class DisableBreakingBySpectator implements Listener{

	public function onPacketSend(DataPacketSendEvent $event){
		foreach($event->getPackets() as $packet){
			if($packet::NETWORK_ID !== SetPlayerGameTypePacket::NETWORK_ID) continue;
			/** @var SetPlayerGameTypePacket $packet */
			foreach($event->getTargets() as $session){
				if($session->getPlayer()?->isSpectator()){
					$packet->gamemode = GameMode::CREATIVE_VIEWER;
				}
			}
		}
	}
}
