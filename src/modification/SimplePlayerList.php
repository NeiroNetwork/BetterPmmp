<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\Server;

class SimplePlayerList implements Listener, Module{

	public function isLoadable() : bool{
		return true;
	}

	public function onDataPacketSend(DataPacketSendEvent $event) : void{
		foreach($event->getPackets() as $packet){
			if($packet::NETWORK_ID === PlayerListPacket::NETWORK_ID){
				/** @var PlayerListPacket $packet */
				if($packet->type !== PlayerListPacket::TYPE_ADD) continue;
				foreach($packet->entries as $entry){
					$player = Server::getInstance()->getPlayerByUUID($entry->uuid);
					if(!is_null($player)) $entry->username = $player->getName();
				}
			}
		}
	}
}
