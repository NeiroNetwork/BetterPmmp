<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\StartGamePacket;

class SuppressEmoteText extends ModuleBase{

	public function onDataPacketSend(DataPacketSendEvent $event) : void{
		$packet = $event->getPackets()[0];	// 大抵はパケット一つしかないからこれで大丈夫っしょ
		if($packet::NETWORK_ID === ProtocolInfo::START_GAME_PACKET){
			/** @var StartGamePacket $packet */
			$packet->levelSettings->muteEmoteAnnouncements = true;
		}
	}
}
