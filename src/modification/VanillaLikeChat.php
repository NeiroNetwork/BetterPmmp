<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\network\mcpe\protocol\TextPacket;
use pocketmine\player\Player;

class VanillaLikeChat implements Listener{

	/**
	 * FIXME?: 優先度MONITORでイベントを変更してはいけないという原則を破ってる
	 * @priority MONITOR
	 */
	public function onPlayerChat(PlayerChatEvent $event) : void{
		$packet = new TextPacket;
		$packet->type = TextPacket::TYPE_CHAT;
		$packet->sourceName = $event->getPlayer()->getDisplayName();
		$packet->message = $event->getMessage();

		$notPlayers = [];

		foreach($event->getRecipients() as $recipient){
			if($recipient instanceof Player){
				$recipient->getNetworkSession()->sendDataPacket($packet);
			}else{
				$notPlayers[] = $recipient;
			}
		}

		$event->setRecipients($notPlayers);
	}

	// TODO: /tell なども TextPacket::TYPE_WHISPER を使って送信する
}
