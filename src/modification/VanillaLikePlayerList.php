<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\Server;

class VanillaLikePlayerList implements Listener{

	public function onDataPacketSend(DataPacketSendEvent $event) : void{
		foreach($event->getPackets() as $packet){
			if($packet::NETWORK_ID === PlayerListPacket::NETWORK_ID){
				/** @var PlayerListPacket $packet */
				if($packet->type !== PlayerListPacket::TYPE_ADD) continue;
				foreach($packet->entries as $entry){
					$entry->username = Server::getInstance()->getPlayerByUUID($entry->uuid)->getName();
				}
			}
		}
	}
}
